
document.addEventListener('DOMContentLoaded', function() {
    var audioElements = document.querySelectorAll('audio');
    
    audioElements.forEach(function(audioElement) {
        // Set the 'controlsList'-attribut
        audioElement.setAttribute('controlsList', 'nodownload');

        // Context menu (right click) for <audio>-elements disabled
        audioElement.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    });
});
