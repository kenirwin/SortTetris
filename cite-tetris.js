var game = {
    debug: function () {
        var listProp=game.listProperties(game);
        listProp += game.listProperties(game.rows);
        $("#debug").html(listProp);
    },

    init: function () {
        alert (data);
        game.data = data;
        game.buttons = ['book','book chapter', 'article'];
        game.controls();
        game.rows = [];
        game.activeRow = 0;
        game.citeText = '';
        game.color = 'lightblue';
        game.blankColor = 'white';
        game.height = 12;
        game.lastClearRow = game.height;
        game.interval = 600;
        for (var i=1; i<(game.height+1); i++) {
            game.rows[i] = -1; //empty
        }
        game.bound = $.browser == 'msie' ? '#game' : window;
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
        $('.game-button').removeClass('inactive').click(function() {
            game.clickEval(this.id);
        });
        $('.start-stop-button').addClass('inactive').unbind();
        game.next();
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
        if (game.givenAnswer === game.currAnswer) {
            game.correct();
        }
        else {
            game.incorrect();
        }
    },
    
    correct: function () {
        game.timer = window.setTimeout(function() { game.next() }, game.interval);
        $('#row'+game.activeRow).html('').css('background-color',game.blankColor);
        game.rows[game.activeRow] = -1;
    },

    incorrect: function () {
        // move to game.lastClearRow
        for (var j=1; j < game.lastClearRow; j++) {
            game.rows[j] = -1;
            $('#row'+j).html('').css('background-color',game.blankColor);
        }
        game.debug();
        $('#row'+game.lastClearRow).html(game.citeText).css('background-color',game.color);
        game.activeRow = game.lastClearRow;
        game.rows[game.activeRow] = 1;
        game.debug();
        game.touchdown();
        game.debug();
    },
    
    
    newCite: function () {
        if (game.rows[1] !== 1) {
            var citeIndex = Math.floor(Math.random()*game.data.length);
            game.citeText = game.data[citeIndex].citation;
            game.currAnswer = game.data[citeIndex].type;
            game.color = "lightblue";
            $('#row1').html(game.citeText).css('background-color',game.color);
            $('#citation').html(game.citeText).css('background-color',game.color);
            game.activeRow = 1;
            game.rows[game.activeRow] = 1;
        }
        else if (game.rows.join('').indexOf('-1') == -1) {
            game.debug();
            game.gameOver();
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
    
    moveDown: function () {
        game.debug();
        var n = game.activeRow;
        if (game.rows[game.activeRow+1] === -1) {
            $('#row'+game.activeRow).html('').css('background-color',game.blankColor);
            game.rows[game.activeRow] = -1;
            game.rows[game.activeRow+1] = 1; 
            game.activeRow++;
            $('#row'+game.activeRow).html(game.citeText).css('background-color',game.color);
        }  
        else {
            game.touchdown();
            return false;
        }
    },

    touchdown: function () {
        game.debug();
        game.lastClearRow = game.activeRow-1;
        
        $('#row'+game.activeRow).css("background-color","red").attr("data-correct",game.currAnswer).attr("data-incorrect",game.givenAnswer);
        window.clearInterval(game.timer);
        game.timer = window.setTimeout(function() { game.next() }, game.interval);
        return false;
    },
    
    gameOver: function () {
        game.debug();
        alert ('Game Over');
        window.clearInterval(game.timer);
        $("#grid td").css("background-color","lightgrey").each(function() {
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
