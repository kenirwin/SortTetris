var game = {
    init: function () {
//        alert ('test: init');
        var i;
        game.rows = [];
        game.activeRow = 0;
        game.citeText = '';
        game.color = 'lightblue';
        game.blankColor = 'white';
        for (i=1; i<13; i++) {
            game.rows[i] = -1; //empty
        }
        game.bound = $.browser == 'msie' ? '#game' : window;
    },

    start: function () {
//        alert ('test: start');
        $(game.bound).keypress(game.key);
        game.next = game.newCite();
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
        game.citeText = "Test Citation";
        game.color = "lightblue";
        $('#row1').text(game.citeText).css('background-color',game.color);
        game.activeRow = 1;
        game.rows[game.activeRow] = 1;
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
        },
};

$(window).load(function() {
    game.init();
    game.start();
});
