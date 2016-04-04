

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
        "citation": "The New Woman in Fiction and in Fact: Fin-de-Siecle Feminisms. New York, NY: Palgrave, 2001.", 
        "type": "book"
    },
    {
        "citation": 'BRENNAN, PATRICK H. 2006. "Journalism." Oxford Companion To Canadian History 332-333.',
        "type": "book chapter"
    },
    {
        "citation": "Women of Minnesota : selected biographical essays. St. Paul : Minnesota Historical Society Press, 1977", 
        "type": "book"
    },
{"citation":"Day, Mike, and Don Revill. 1995. Towards the active collection: The use of circulation analyses in collection evaluation. Journal of Librarianship and Information Science 27 (September): 149-157.","type":"article"},{"citation":"Evans, G. Edward. 2000. Developing library and information center collections. 4th ed. Englewood, CO: Libraries Unlimited.","type":"book"},{"citation":"Peasgood, Adrian N. 1986. Towards demand-led book acquisitions? Experiences in the University of Sussex Library. Journal of Librarianship 18 (October): 242-256.","type":"article"},{"citation":"Bridges, L., Rempel, H., & Griggs, K. (2010). Making the case for a fully mobile library web site: from floor maps to the catalog. Reference Services Review, 38, 309-320.","type":"article"},{"citation":"Fling, Brian. (2009) Mobile Design and Development. Sebastopol, CA: O'Reilly","type":"book"},{"citation":"Haefele, C. (2011). One Block at a Time: Building a Mobile Site Step by Step. Reference Librarian, 52, 117-127.","type":"article"},{"citation":"Ragon, B. (2009). Designing for the Mobile Web. Journal of Electronic Resources in Medical Libraries, 6, 355-361. doi:10.1080/15424060903364875","type":"article"},{"citation":"Smith, S.D. & Caruso J.B. (2009). ECAR Study of Undergraduate Students and Information Technology, Boulder, CO: EDUCAUSE Center for Applied Research. ","type":"book"},{"citation":"Wisniewski, Jeff. (2010). .Mobile Websites With Minimum Effort.. Online. Vol. 34(1), 54-57.","type":"article"},{"citation":"Whitlock, G. (2007), Soft weapons.: autobiography in transit, Chicago.: University of Chicago Press, 2007.","type":"book"},{"citation":"Winick, J. (2000), Pedro and Me: Friendship, Loss, and What I Learned, Heny Holt, New York.","type":"book"},{"citation":"Witek, J. (1999), .Ramses in the Ivory Tower., The Comics Journal, April 1999, No. 211, pp. 58.61.","type":"article"},{"citation":"Wolfe, G.K. (1994), .On Some Recent Scholarship., Science Fiction Studies, Vol. 21 No. 3, pp. 439.440.","type":"article"},{"citation":"Schack, T. (2014), ..A failure of language.: Achieving layers of meaning in graphic journalism.., Journalism, Vol. 15 No. 1, pp. 109.127.","type":"article"},{"citation":"Rader, P.J. (2012), .Readings and Rebellions in Persepolis and Persepolis 2., in Jakaitis, J. and Wurtz, J.F. (Eds.),Crossing Boundaries in Graphic Narrative: Essays on Forms, Series and Genres, McFarland, Jefferson, N.C., pp. 123.137.","type":"book chapter"},{"citation":"Oppegaard, B. (2012), .A Review of .The Influencing Machine: Brooke Gladstone on the Media..., Visual Communication Quarterly, Vol. 19 No. 3, pp. 191.193.","type":"article"},{"citation":"National Commission on Terrorist Attacks. (2004), The 9/11 Commission Report: Final Report of the National Commission on Terrorist Attacks Upon the United States, W. W. Norton & Company, New York.","type":"book"},{"citation":"Neufeld, J. (2010), A.D.: New Orleans After the Deluge, Pantheon, New York.","type":"book"},{"citation":"Mack, S. (2012), Taxes, the Tea Party, and Those Revolting Rebels: A History in Comics of the American Revolution, NBM Publishing, New York.","type":""},{"citation":"Loman, A. (2010), ..That Mouse.s Shadow.: The Canonization of Maus., in Williams, P. and Lyons, J. (Eds.), The Rise of the American Comics Artist, University Press of Mississippi, Jackson.","type":"book chapter"},{"citation":"Gruber, J. (2011a), .The Impacts Of The Affordable Care Act: How Reasonable Are The Projections the Impacts Of The Affordable Care Act: How Reasonable Are The Projections?., National Tax Journal, Vol. 64 No. 3, pp. 893-908.","type":"article"},{"citation":"Gordon, I. (2010), .Making Comics Respectable: How Maus Helped Redefine a Medium., The Rise of the American Comics Artist: Creators and Contexts, University of Mississippi Press, Jackson, pp. 160.167.","type":"book chapter"},{"citation":"Doucet, J. (1999), My Most Secret Desire, Drawn & Quarterly, Montre.al.","type":"book"},{"citation":"Doxiadis, A. and Papadimitriou, C.H. (2009), Logicomix: An Epic Search for Truth, Bloomsbury USA, New York.","type":"book"}
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
        game.interval = 600;
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
            $('#citation').text(game.citeText).css('background-color',game.color);
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
