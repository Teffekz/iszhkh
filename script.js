document.getElementById('popup_activator').addEventListener('click', function() {
    var popup = document.getElementById('popup');
    popup.classList.remove('hidden');
});

document.getElementById('popup_closer').addEventListener('click', function() {
    var popup = document.getElementById('popup');
    popup.classList.add('hidden');
});