
function $(str) {
    return document.querySelector(str);
}

/*Menu show and hide on songs*/
function showListMenu(elm) {
    // var previous = document.querySelectorAll('.track-menu.show-menu');
    // previous.forEach(function(item) {
    // 	item.classList.remove('show-menu')
    // })
    elm.closest('.cr-img-content').childNodes[9].classList.toggle('show-menu');
}

/*Menu show and hide on Songs Playlist panel*/
function showListPLMenu(elm) {
    // var previous = document.querySelectorAll('.t-menu-2.pl-show');
    // previous.forEach(function(item) {
    // 	item.classList.remove('pl-show')
    // })
    elm.closest('.pl-song').childNodes[11].classList.toggle('pl-show');

}

/*Menu show and hide on Main player*/
if (document.querySelector('.mp-icon') !== null) {
    document.querySelector('.mp-icon').addEventListener('click', function(){
        $(".t-menu-2").classList.toggle("tm_show");
    });
}
/*Playlist show and hide on Playlist Icon*/
if (document.querySelector('#song-playlist-i') !== null) {
    document.querySelector('#song-playlist-i').addEventListener('click', function(){
        $("#pl-songlist").classList.toggle("tm_show");
    });
}

/*Playlist close on cross icon click*/
if (document.querySelector('.pl-close-btn') !== null) {
    document.querySelector('.pl-close-btn').addEventListener('click', function(){
        $("#pl-songlist").classList.remove("tm_show");
    });
}

// function showBlock(){
// 	document.querySelector(".hide-show-b").style.display = 'block';
// 	document.querySelector(".hide-show-b2").style.display = 'flex';
// }
// function hideBlock(){
// 	document.querySelector(".hide-show-b").style.display = 'none';
// 	document.querySelector(".hide-show-b2").style.display = 'none';
// }

/*NO radio button selection*/
if (document.querySelector('#ritema') !== null){
    document.querySelector('#ritema').onclick = function (e) {
        document.querySelector(".hide-show-b").style.display = 'block';
        document.querySelector(".hide-show-b3").style.display = 'flex';
    }
}

/*Yes, with voice tag (MP3 Version) radio button selection*/
if (document.querySelector('#ritemb') !== null){
    document.querySelector('#ritemb').onclick = function (e) {
        document.querySelector(".hide-show-b").style.display = 'none';
        document.querySelector(".hide-show-b3").style.display = 'none';
    }
}

/*Exclusive radio button selection*/
if (document.querySelector('#license2') !== null) {
    document.querySelector('#license2').onclick = function (e) {
        document.querySelector(".hide-show-b2").style.display = 'block';
        document.querySelector(".info-edit").style.display = 'block';
    }
}

/*Non-Exclusive radio button selection*/
if (document.querySelector('#license') !== null) {
    document.querySelector('#license').onclick = function (e) {
        document.querySelector(".hide-show-b2").style.display = 'none';
        document.querySelector(".info-edit").style.display = 'none';
    }
}

if (document.querySelector('#flip-card')) {
    document.querySelector('#flip-card').onclick = function (e) {
        $("#flip-card").classList.toggle("fliped-side");
    }
}

/*Popus Modal for Buy Beats*/
function openModal() {
    document.getElementById("backdrop").style.display = "block";
    document.getElementById("buyBeatsModal").style.display = "block";
    document.getElementById("buyBeatsModal").classList.add("show");
}
function closeModal() {
    document.getElementById("backdrop").style.display = "none";
    document.getElementById("buyBeatsModal").style.display = "none";
    document.getElementById("buyBeatsModal").classList.remove("show");
}




/*Popup Modal for create new playlist*/
function playlistOpen() {
    document.getElementById("backdrop").style.display = "block";
    document.getElementById("playlistModal").style.display = "block";
    document.getElementById("playlistModal").classList.add("show");
    document.getElementById("artworkModal").style.display = "none";
    document.getElementById("croppedImage").style.display = "none";

}
function playlistClose() {
    document.getElementById("backdrop").style.display = "none";
    document.getElementById("playlistModal").style.display = "none";
    document.getElementById("playlistModal").classList.remove("show");
    // document.getElementById("croppedImage").style.display = "none";
    // document.getElementById("artworkModal").style.display = "none";
}

/*Popup Modal for Upload cover Artwork*/
function artworkOpen() {
    document.getElementById("backdrop").style.display = "block";
    document.getElementById("artworkModal").style.display = "block";
    document.getElementById("artworkModal").classList.add("show");
    document.getElementById("playlistModal").style.display = "none";

}
function artworkClose() {
    document.getElementById("backdrop").style.display = "none";
    document.getElementById("artworkModal").style.display = "none";
    document.getElementById("artworkModal").classList.remove("show");
    document.getElementById("playlistModal").style.display = "block";
}

/*Popup Modal After Croping the cover Image*/
function croppedOpen() {
    document.getElementById("backdrop").style.display = "block";
    document.getElementById("croppedImage").style.display = "block";
    document.getElementById("croppedImage").classList.add("show");
    document.getElementById("artworkModal").style.display = "none";
    document.getElementById("playlistModal").style.display = "none";
}
function croppedClose() {
    document.getElementById("backdrop").style.display = "none";
    document.getElementById("croppedImage").style.display = "none";
    document.getElementById("croppedImage").classList.remove("show");
    // document.getElementById("playlistModal").style.display = "block";
}

/*Popup Modal After Croping the cover Image*/
function liveOpen() {
    document.getElementById("backdrop").style.display = "block";
    document.getElementById("liveSession").style.display = "block";
    document.getElementById("liveSession").classList.add("show");
}
function liveClose() {
    document.getElementById("backdrop").style.display = "none";
    document.getElementById("liveSession").style.display = "none";
    document.getElementById("liveSession").classList.remove("show");
}

/*Popup Modal Decline Contract offer (Producer side)*/
function declineOpen() {
    document.getElementById("backdrop").style.display = "block";
    document.getElementById("declineModal").style.display = "block";
    document.getElementById("declineModal").classList.add("show");
}
function declineClose() {
    document.getElementById("backdrop").style.display = "none";
    document.getElementById("declineModal").style.display = "none";
    document.getElementById("declineModal").classList.remove("show");
}

// Get the modal
var beatModal = document.getElementById('buyBeatsModal');
var playlistModal = document.getElementById('playlistModal');
var liveSession = document.getElementById('liveSession');
var declineModal = document.getElementById('declineModal');
// var artworkModal = document.getElementById('artworkModal');
// var croppedImage = document.getElementById('croppedImage');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == beatModal) {
        closeModal();
    }
    if (event.target == playlistModal) {
        playlistClose();
    }
    if (event.target == liveSession) {
        liveClose();
    }

    if (event.target == declineModal) {
        declineClose();
    }
    // if (event.target == artworkModal) {
    //     artworkClose()
    // }
    // if (event.target == croppedImage) {
    //     croppedClose()
    // }
}



window.onload=function(){

    /*Notification Icon toggle show and hide*/
    if (document.querySelector('#nt-i2') !== null){
        document.querySelector('#nt-i2').onclick = function (e) {
            document.querySelector("#notification-box").classList.toggle("nt-show");
        }
    }
    /*Sidebar open and close for Chatting screen on Tablet/Mobile views*/
    if (document.querySelector('#chat-s-btn') !== null){
        document.querySelector('#chat-s-btn').onclick = function (e) {
            document.querySelector("#msg-sidebar").classList.add("chats-con-show");
            document.querySelector("#chat-s-btn").classList.add("chats-btn-hide");
        }
    }
    /*Sidebar open and close for Chatting screen on Tablet/Mobile views*/
    if (document.querySelector('#chat-s-btn2') !== null){
        document.querySelector('#chat-s-btn2').onclick = function (e) {
            document.querySelector("#msg-sidebar").classList.remove("chats-con-show");
            document.querySelector("#chat-s-btn").classList.remove("chats-btn-hide");
        }
    }

    /*Dropdown for Chatting screen menu in header*/
    if (document.querySelector('#ch-m-btn') !== null){
        document.querySelector('#ch-m-btn').onclick = function (e) {
            document.querySelector("#chat-dropdown").classList.toggle("chat-dropdown-show");
            document.querySelector("#ch-m-btn").classList.toggle("chat-menu-ch");

        }
    }

    // Paypal switch on Beat Purchase page
    if (document.querySelector('#paypal-op') !== null){
        document.querySelector('#paypal-op').onclick = function (e) {
            document.getElementById("hide-show-bl").style.display = "none";
            document.getElementById("pay-tooltip").style.display = "none";
            document.getElementById("paypal-scr").style.display = "flex";
        }
    }
    // Credit Card switch on Beat Purchase page
    if (document.querySelector('#card-op') !== null){
        document.querySelector('#card-op').onclick = function (e) {
            document.getElementById("hide-show-bl").style.display = "block";
            document.getElementById("pay-tooltip").style.display = "block";
            document.getElementById("paypal-scr").style.display = "none";
        }
    }


    /*=========================================================*/


    /* Select genre using checkboxes in Upload Beats page*/
    if (document.querySelector('#genre-select') !== null){
        document.querySelector('#genre-select').onclick = function (e) {
            document.getElementById("checkbox-con").classList.toggle("checkbox-con-show");
        }
    }


    /*Hamburger menu button toggle*/
    document.querySelector('#ham-btn').onclick = function (e) {

        document.querySelector('#search-options').classList.add('none')
        document.querySelector('#search-input').classList.add('none')

        document.querySelector('#nav-icon3').classList.toggle('open');
        var nav_li_i = document.getElementById('nav-li-i');

        if (nav_li_i.classList.contains('nv_show')) {
            nav_li_i.classList.remove('nv_show');
        }
        else{
            nav_li_i.classList.add('nv_show');
        }
        e.preventDefault();
    }

    /*Search Icon toggle*/
    document.querySelector('#n-srch-i').addEventListener('click', function(){

        if (screen.width <= 768) {
            document.querySelector('#nav-icon3').classList.remove('open');
            document.querySelector('#nav-li-i').classList.remove('nv_show');

            document.querySelector('#search-options').classList.toggle('none')
            document.querySelector('#search-input').classList.toggle('none')
        }
    });
}



//  Main Player
function mainPlayer(){
    document.querySelector('.main-player').style.visibility ='visible';
    document.querySelector('.main-player').style.opacity ='1';
    document.querySelector('.main-player').style.bottom ='0';
}

/*Main Player */
if(document.getElementById("song-duration") !== null) {
    const slider = document.getElementById("song-duration");
    const min = (slider == null)? "NA": slider.min
    const max = (slider == null)? "NA": slider.max
    const value = (slider == null)? "NA": slider.value

    slider.style.background = `linear-gradient(to right, #FE2B0D 0%, #FE2B0D ${(value-min)/(max-min)*100}%, #474747 ${(value-min)/(max-min)*100}%, #474747 100%)`

    slider.oninput = function() {
        this.style.background = `linear-gradient(to right, #FE2B0D 0%, #FE2B0D ${(this.value-this.min)/(this.max-this.min)*100}%, #474747 ${(this.value-this.min)/(this.max-this.min)*100}%, #474747 100%)`
    };
}

/*List view and Card Switcher*/
let list_add = document.querySelector('#tracks-container');
let list_v = document.querySelector('#list-view-i');
let card_v = document.querySelector('#card-view-i');

if (list_v) {
    list_v.addEventListener('click', () =>{
        list_add.classList.add('list-view');
        card_v.classList.remove('active-view');
        list_v.classList.add('active-view');
    })
}

if (card_v) {
    card_v.addEventListener('click', () =>{
        list_add.classList.remove('list-view');
        list_v.classList.remove('active-view');
        card_v.classList.add('active-view');
    })
}


/*================================================*/

