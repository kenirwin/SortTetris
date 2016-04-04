

var game = {
    init: function () {
//        alert ('test: init');
        var i;
data = [
    { 
        "citation": "ATQ. Jun98, Vol. 12 Issue 2, p145.",
        "type" : "article"
    },
    { 
        "citation": "Burke, Susan L., et al. ''Letters.'' Ms 22.1 (2012): 6-8.", 
        "type" : "article"
    },
    { 
        "citation": "Albert H. University of Chicago Law Review. Spring2008, Vol. 75 Issue 2, p649-714.",
        "type": "article"
    },
    {
        "citation": "The New Woman in Fiction and in Fact: Fin-de-Siecle Feminisms. 122-135. New York, NY: Palgrave, 2001.", 
        "type": "book"
    },
    {
        "citation": 'BRENNAN, PATRICK H. 2006. "Journalism." Oxford Companion To Canadian History 332-333.',
        "type": "book chapter"
    },
    {
        "citation": "Women of Minnesota : selected biographical essays. St. Paul : Minnesota Historical Society Press, 1977", 
        "type": "book"
    }
];
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
        game.interval = 300;
        for (i=1; i<(game.height+1); i++) {
            game.rows[i] = -1; //empty
        }
        game.bound = $.browser == 'msie' ? '#game' : window;
    },


    controls: function () {
        var buttonsHTML = '';
        for (var i = 0; i < game.buttons.length; i++) {
            buttonsHTML += '<br/><button class="game-button" id="'+game.buttons[i]+'">'+game.buttons[i]+'</button><br/>';
        }

        $('#controls').html(buttonsHTML);
    },


    start: function () {
//        alert ('test: start');
//        $(game.bound).keypress(game.key); // accept keyboard input
        $('.game-button').click(function() {
            game.clickEval(this.id);
        });
        game.next();
    },
    
    next: function () {
        game.debug();
        game.nextCite = game.newCite();
        game.timer = window.setInterval(game.moveDown, game.interval);
    },

    key: function(e) {
        alert(e.charCode);
        switch(e.charCode) {
        case 97: break; //a
        case 98: break; //b
        }
        return false;
    },
    
    clickEval: function (id) {
       window.clearInterval(game.timer);
        game.debug();

       if (id === game.currAnswer) {
            game.correct();
        }
        else {
            game.incorrect();
        }
    },

    correct: function () {
         game.timer = window.setTimeout(function() { game.next() }, game.interval);
        $('#row'+game.activeRow).text('').css('background-color',game.blankColor);
        game.rows[game.activeRow] = -1;
    },

    incorrect: function () {
        // move to game.lastClearRow
        for (var j=1; j < game.lastClearRow; j++) {
            game.rows[j] = -1;
            $('#row'+j).text('').css('background-color',game.blankColor);
        }
        game.debug();
        $('#row'+game.lastClearRow).text(game.citeText).css('background-color',game.color);
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
            $('#row1').text(game.citeText).css('background-color',game.color);
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
    
    debug: function () {
        var listProp=game.listProperties(game);
        listProp += game.listProperties(game.rows);
        $("#debug").html(listProp);
    },

    moveDown: function () {
        game.debug();
        var n = game.activeRow;
        if (game.rows[game.activeRow+1] === -1) {
            $('#row'+game.activeRow).text('').css('background-color',game.blankColor);
            game.rows[game.activeRow] = -1;
            game.rows[game.activeRow+1] = 1; 
            game.activeRow++;
            $('#row'+game.activeRow).text(game.citeText).css('background-color',game.color);
          }  
        else {
            game.touchdown();
            return false;
        }
        },
    touchdown: function () {
        game.debug();
        game.lastClearRow = game.activeRow-1;

        $('#row'+game.activeRow).css("background-color","red");
        window.clearInterval(game.timer);
        game.timer = window.setTimeout(function() { game.next() }, game.interval);
        return false;
    },

    gameOver: function () {
        game.debug();
        alert ('Game Over');
        window.clearInterval(game.timer);
        $("#grid td").css("background-color","lightgrey");
        delete game.timer;
        $("#controls .game-button").unbind();
        die();
    },


};

$(window).load(function() {
    game.init();
    game.start();
});
