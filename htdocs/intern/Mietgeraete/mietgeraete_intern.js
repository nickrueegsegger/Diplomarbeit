function loadBrands() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_brands.php', true);
    xhr.onload = function() {
        if (this.status == 200) {
            var brands = JSON.parse(this.responseText);
              // Marken alphabetisch nach MarkenName sortieren
              brands.sort(function (a, b) {
                return a.MarkenName.localeCompare(b.MarkenName);
            });
            var output = '';
            for (var i in brands) {
                output += '<option value="' + brands[i].MarkenID + '">' + brands[i].MarkenName + '</option>';
            }
            document.getElementById('brandSelect').innerHTML = output;
        }
    }
    xhr.send();
}
window.addEventListener("load", function() {
    loadBrands();
});

