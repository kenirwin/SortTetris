

var game = {
    init: function () {
//        alert ('test: init');
        var i;
data = [
    { 
        "citation": "ATQ. Jun98, Vol. 12 Issue 2, p145.",
        "type" : "journal article"
    },
    { 
        "citation": "Burke, Susan L., et al. ''Letters.'' Ms 22.1 (2012): 6-8.", 
        "type" : "journal article"
    },
    { 
        "citation": "Albert H. University of Chicago Law Review. Spring2008, Vol. 75 Issue 2, p649-714.",
        "type": "journal"
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



        game.rows = [];
        game.activeRow = 0;
        game.citeText = '';
        game.color = 'lightblue';
        game.blankColor = 'white';
        for (i=1; i<13; i++) {
            game.rows[i] = -1; //empty
        }
        game.bound = $.browser == 'msie' ? '#game' : window;
        alert (data[1].type);
    },

    start: function () {
//        alert ('test: start');
        $(game.bound).keypress(game.key);
        game.next();
    },
    
    next: function () {
        game.nextCite = game.newCite();
        game.delay=300;
        game.timer = window.setInterval(game.moveDown, game.delay);
    },

    key: function(e) {
        alert(e.charCode);
        switch(e.charCode) {
        case 97: break; //a
        case 98: break; //b
        }
        return false;
    },
    
    newCite: function () {
        if (game.rows[1] !== 1) {
        game.citeText = "Test Citation";
        game.color = "lightblue";
        $('#row1').text(game.citeText).css('background-color',game.color);
        game.activeRow = 1;
        game.rows[game.activeRow] = 1;
        }
    },

    moveDown: function () {
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
        $('#row'+game.activeRow).css("background-color","red");
        window.clearInterval(game.timer);
        game.timer = window.setTimeout(function() { game.next() }, 100);
        return false;
    }
};

$(window).load(function() {
    game.init();
    game.start();
});
