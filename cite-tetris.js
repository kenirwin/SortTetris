var game = {
    debug: function () {
        var listProp=game.listProperties(game);
        listProp += game.listProperties(game.rows);
        $("#debug").html(listProp);
    },

    init: function () {
        game.data = data; // defined in external file specified in settings.php
        game.buttons = settings_buttons; //defined in settings.php
        game.audioOK = settings_audioOK; //defined in settings.php
        game.itemLabel = settings_itemLabel; //defined in settings.php
        game.pointUnits = 100;
        game.interval = 600; //hundredths of seconds between move down
        game.height = 12;
        game.correctPerLevel = 6;
        game.correctThisLevel = 0; //always start at zero
        game.winAtLevel = 6;
        game.intervalDecreasePerLevel=50;
        game.controls();
        game.rows = [];
        game.activeRow = 0;
        game.citeText = '';
        game.colors = [
            ['#00e427', '#bdffca', '#009c1a', '#00961a', '#2dff55'], //green
            ['#e4de00','#ffffbd','#a39c00','#968f00','#fff83a'], //yellow
            ['#00e4e4','#c4ffff','#00aaaa','#009696','#34ffff'], //lightblue
            ['#e40027','#ffbdca','#a3001a','#96001a','#ff345b'], //red
            ['#9c13e4','#ebbdff','#6f009c','#620096','#c441ff'], //purple
        ];
        game.blankColor = 'white';
        game.lastClearRow = game.height;
        game.level = 1;
        game.score = 0;
        game.nCorrect = 0;
        game.nTotal = 0;
        game.answerLog = [];
        for (var i=1; i<(game.height+1); i++) {
            game.rows[i] = -1; //empty
        }
        game.bound = $.browser == 'msie' ? '#game' : window;
    },

    logStatus: function() { 
        console.log('=======================');
        console.log('N:' + game.nTotal);
        console.log('Correct:' + game.nCorrect);
        console.log('Percent:' + game.nCorrect/game.nTotal);
        console.log(game.answerLog);
    },

    getStats: function () {
        var str='Total '+game.itemLabel+'s: ' +game.nTotal+ '<br />';
        str+='Total correct: ' +game.nCorrect+ '<br />';
        str+='Percent correct: ' +Math.round(100*game.nCorrect/game.nTotal)+ '%';
        return str;
    },

    getLongStats: function () { 
        var answers = [];
        game.possibleAnswers = game.buttons;
        game.possibleAnswers.push('No Answer');
        for (i = 0; i < game.answerLog.length; i++) {
            var correct=game.answerLog[i][0];
            var answered=game.answerLog[i][1];
            if (answers[correct] == null) { 
                answers[correct] = [];
            }
            if (answers[correct][answered] == null) {
                answers[correct][answered] = 1;
            }
            else {
                answers[correct][answered]++;
            }
        }

        var key_count=[];
        for (j=0; j<game.possibleAnswers.length; j++) { 
            for (k=0; k<game.possibleAnswers.length; k++) {
                var key1 = game.possibleAnswers[j];
                var key2 = game.possibleAnswers[k];
                if (answers[key1] !== undefined) {
                    if (answers[key1][key2] !== undefined) {
                        var this_key_count = answers[key1][key2];
                        console.log(key1 +'+'+ key2 + ':' + this_key_count);
                        if (key_count[key1] == undefined) {
                            key_count[key1] = this_key_count;
                        }
                        else {
                            key_count[key1] += this_key_count;
                        }
                        console.log(key1 + ' count: '+ key_count[key1]);
                    }
                }
            }
        }
        
        var output = '';
        // go through again to calculate percentages and build display
        for (j=0; j<game.possibleAnswers.length; j++) { 
            var key1 = game.possibleAnswers[j];
            if (answers[key1] !== undefined) {
                output+='<tr class="score-header"><td colspan="3">Where correct answer is: <b>'+key1+'</b><br />You answered...</td></tr>';

            for (k=0; k<game.possibleAnswers.length; k++) {
                var key2 = game.possibleAnswers[k];
                    if (answers[key1][key2] !== undefined) {
                        var percent = answers[key1][key2]/key_count[key1];
                        if (key1 == key2) { 
                            var score_class = 'score-correct';
                        }
                        else {
                            var score_class = 'score-incorrect';
                        }
                        output+= '<tr class="'+score_class+'"><td>' + key2 + '</td><td>' +answers[key1][key2]+ '</td><td>' + Math.round(percent*100) +'%</td></tr>';                        
                    }
                }
            }
        }
        output = '<table>'+output+'</table>';
        return output;
    },
    
    controls: function () {
        var buttonsHTML = '';
        buttonsHTML += '<br /><button class="start-stop-button" id="start">Start Game</button><br />';
        for (var i = 0; i < game.buttons.length; i++) {
            buttonsHTML += '<br/><button class="game-button inactive" id="'+game.buttons[i]+'">'+game.buttons[i]+'</button><br/>';
        }
        $('#controls').html(buttonsHTML);
        $('.start-stop-button').click(function() {
            game.start();
        });
    },


    start: function () {
        $('#long-stats').hide();
        $('.game-button').removeClass('inactive').show().click(function() {
            game.clickEval(this.id);
        });
        $('.start-stop-button').addClass('inactive').unbind();
        game.next();
	    if (game.audioOK === true) { playaudio(); }
    },
    
    pause: function () {

    },
    
    next: function () {
        game.debug();
        game.nextCite = game.newCite();
        game.timer = window.setInterval(game.moveDown, game.interval);
    },

    clickEval: function (id) {
        window.clearInterval(game.timer);
        game.debug();
        game.givenAnswer = id;
        game.nTotal++;
        game.answerLog.push([game.currAnswer, game.givenAnswer]);
        if (game.givenAnswer === game.currAnswer) {
            game.correct();
        }
        else {
            game.incorrect();
        }
        game.logStatus();
    },
    
    correct: function () {
        game.timer = window.setTimeout(function() { game.next() }, game.interval);
        $('#row'+game.activeRow).html('').css('background-color',game.blankColor).css('border-color',game.blankColor);
        game.rows[game.activeRow] = -1;
        game.correctThisLevel++;
        game.score += game.level * game.pointUnits;
        game.nCorrect++;
        if (game.correctThisLevel == game.correctPerLevel) {
            game.correctThisLevel=0;
            game.interval-=game.intervalDecreasePerLevel;
            game.level++;
	    speedUp();
        }
        $('#score').html('Level: '+game.level+'<br />Score: ' + game.score);
        if (game.level == game.winAtLevel) {
            game.gameOver("win");
        }
    },

    incorrect: function () {
        // move to game.lastClearRow
        for (var j=1; j < game.lastClearRow; j++) {
            game.rows[j] = -1;
            $('#row'+j).html('').css('background-color',game.blankColor).css('border-color',game.blankColor);
        }
        game.debug();
        $('#row'+game.lastClearRow).html(game.citeText);
        game.addCSS(game.colorIndex, '#row'+game.lastClearRow);
        game.activeRow = game.lastClearRow;
        game.rows[game.activeRow] = 1;
        game.debug();
        game.touchdown();
        game.debug();
    },
    
    
    newCite: function () {
        if (game.rows[1] !== 1) {
            var citeIndex = Math.floor(Math.random()*game.data.length);
            game.citeText = game.data[citeIndex].item;
            game.currAnswer = game.data[citeIndex].type;
            game.givenAnswer = '';
            var colorIndex = Math.floor(Math.random()*game.colors.length);
            game.colorIndex = colorIndex;
            $('#row1').html(game.citeText);
            game.addCSS(colorIndex, '#row1');
            $('#item').html(game.citeText);
            game.addCSS(colorIndex, '#item');
            game.activeRow = 1;
            game.rows[game.activeRow] = 1;
        }
        else if (game.rows.join('').indexOf('-1') == -1) {
            game.debug();
            game.gameOver("lose");
        }
    },
    
    listProperties: function(obj) {
        var list='';
        for (var propertyName in obj) {
            if (typeof obj[propertyName] == "string" || typeof obj[propertyName] == "number") {
                list += '<li>'+propertyName+': ' + obj[propertyName]+ '</li>';
            }
            else { 
                list += '<li>'+propertyName+': ' + typeof obj[propertyName]+ '</li>';
            }
            
        }
        return list;
    },

    addCSS: function (index, id) {
        var borderstring = game.colors[index][1]; // + ' ' + game.colors[index][2]) + ' ' + game.colors[index][3] + ' ' + game.colors[index][4];
        $(id).css('background-color',game.colors[index][0])
            .css('border-width','5px')
            .css('border-style','solid')
            .css('border-top-color', game.colors[index][1])
            .css('border-right-color', game.colors[index][2])
            .css('border-bottom-color', game.colors[index][3])
            .css('border-left-color', game.colors[index][4]);
    },
    
    moveDown: function () {
        game.debug();
        var n = game.activeRow;
        if (game.rows[game.activeRow+1] === -1) {
            $('#row'+game.activeRow).html('').css('background-color',game.blankColor).css('border-color',game.blankColor)
            game.rows[game.activeRow] = -1;
            game.rows[game.activeRow+1] = 1; 
            game.activeRow++;
            $('#row'+game.activeRow).html(game.citeText);
            game.addCSS(game.colorIndex, '#row'+game.activeRow);

        }  
        else {
            game.touchdown();
            return false;
        }
    },

    touchdown: function () {
        game.debug();
        game.lastClearRow = game.activeRow-1;
        if (game.givenAnswer == '') { 
            game.givenAnswer = "No Answer"; 
            game.answerLog.push([game.currAnswer, game.givenAnswer]);
            game.nTotal++;
        }
        $('#row'+game.activeRow).attr("data-correct",game.currAnswer).attr("data-incorrect",game.givenAnswer);
        window.clearInterval(game.timer);
        game.timer = window.setTimeout(function() { game.next() }, game.interval);
        game.logStatus();
        return false;
    },

    levelUp: function () { 
    },

    gameOver: function (winOrLose) {
        if (game.audioOK === true) { pauseaudio(); } 
        game.debug();
        $('.game-button').hide();
        var stats = game.getStats();
        var longStats = game.getLongStats();
        $('#item').html('Game Stats: ' + stats +' </p>');
        $('#long-stats').html(longStats).show();
        alert ('Game Over: You ' + winOrLose + '!');
        window.clearInterval(game.timer);
        $("#grid td").css("background-color","lightgrey").css("border-color","lightgrey").each(function() {
            $(this).append(
                $('<br /><span>Correct: '+$(this).attr("data-correct")+' </span>').addClass("overlay correct") 
                    .append($('<span> Your Answer: '+$(this).attr('data-incorrect')+'</span>').addClass("incorrect"))
            );
        });
        delete game.timer;
        $("#controls .game-button").addClass('inactive').unbind();
        $(".start-stop-button").removeClass('inactive').click(function() {
            for (var i=0; i<game.height+1; i++) {
                $('#row'+i).text('').css('background-color',game.blankColor);
            }
            game.init();
            game.start();
        });
        die();
    },
};

$(window).load(function() {
    game.init();
});
