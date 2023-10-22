function loadDevices(brandFilter = null) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_devices.php', true);
    xhr.onload = function () {
        if (this.status == 200) {
            try {
                var devices = JSON.parse(this.responseText);

                // Geräte nach Marke filtern, wenn ein Filter aktiv ist
                if (brandFilter) {
                    devices = devices.filter(function (device) {
                        return device.MarkenName === brandFilter;
                    });
                }

                // Geräte alphabetisch nach Marke und Modell sortieren
                devices.sort(function (a, b) {
                    if (a.MarkenName === b.MarkenName) {
                        return a.Modell.localeCompare(b.Modell);
                    }
                    return a.MarkenName.localeCompare(b.MarkenName);
                });
                var outputAvailable = '';

                for (var i in devices) {
                    var row = '<tr>' +
                    '<td><input type="checkbox" name="deviceIds[]" value="' + devices[i].SortimentID + '"></td>' +
                    '<td>' + devices[i].MarkenName + '</td>' +
                    '<td>' + devices[i].Modell + '</td>' +
                    '<td>' + devices[i].Typ + '</td>' +
                    '<td>' + devices[i].Einkaufspreis_exkl_mwst + '</td>' +
                    '<td>' + devices[i].Verkaufspreis + '</td>' +
                    '<td>' + devices[i].Lagerbestand + '</td>' + 
                    '</tr>';
                

                    outputAvailable += row;
                }
                document.getElementById('availableDeviceTableBody').innerHTML = outputAvailable;
            } catch (e) {
                console.error("JSON parsing failed:", e);
            }
        }
    };
    xhr.send();
}

function loadBrands() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_brands.php', true);
    xhr.onload = function () {
        if (this.status == 200) {
            try {
                var brands = JSON.parse(this.responseText);

                // Geräte alphabetisch nach MarkenName sortieren
                brands.sort(function (a, b) {
                    return a.MarkenName.localeCompare(b.MarkenName);
                });

                var output = '<option value="" selected>Marke auswählen</option>';
                for (var i in brands) {
                    output += '<option value="' + brands[i].MarkenID + '">' + brands[i].MarkenName + '</option>';
                }
                document.getElementById('brandSelect').innerHTML = output;
                document.getElementById('brandFilter').innerHTML += output;
            } catch (e) {
                console.error("JSON parsing failed:", e);
            }
            document.getElementById('brandFilter').addEventListener('change', function() {
    loadDevices();
});document.getElementById('brandFilter').addEventListener('change', function() {
    var selectedBrand = this.options[this.selectedIndex].text;
    loadDevices(selectedBrand);
});
        }
    };
    xhr.send();
}

function loadTypes() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_type.php', true);
    xhr.onload = function () {
        if (this.status == 200) {
            try {
                var types = JSON.parse(this.responseText);
                var output = '';
                for (var i in types) {
                    output += '<option value="' + types[i].GeraetetypID + '">' + types[i].Geraetebezeichnung + '</option>';
                }
                document.getElementById('typeSelect').innerHTML = output;
            } catch (e) {
                console.error("JSON parsing failed:", e);
            }
        }
    };
    xhr.send();
}

function loadSortimentDevices() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_devices.php', true);
    xhr.onload = function () {
        if (this.status == 200) {
            try {
                var devices = JSON.parse(this.responseText);
                devices.sort(function (a, b) {
                    if (a.MarkenName === b.MarkenName) {
                        return a.Modell.localeCompare(b.Modell);
                    }
                    return a.MarkenName.localeCompare(b.MarkenName);
                });
                var output = '<option value="" selected>Gerät auswählen</option>';
                for (var i in devices) {
                    output += '<option value="' + devices[i].SortimentID + '" data-seriennummer="' + devices[i].Seriennummer + '">' + devices[i].MarkenName + ' ' + devices[i].Modell + '</option>';
                }
                document.getElementById('sortimentDropdown').innerHTML = output;
            } catch (e) {
                console.error("JSON parsing failed:", e);
            }
        }
    };
    xhr.send();
}


document.addEventListener("DOMContentLoaded", function () {
    loadDevices();
    loadBrands();
    loadTypes();
    loadSortimentDevices();
    loadLagerGeraete();
    loadSoldDevices();

    document.getElementById('deleteSortimentButton').addEventListener('click', function () {
        var selectedDevices = [];
        var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');

        for (var checkbox of checkboxes) {
            selectedDevices.push(checkbox.value);
        }

        if (selectedDevices.length === 0) {
            alert('Bitte wählen Sie mindestens ein Gerät aus.');
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_devices.php', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (this.status === 200) {
                alert(this.responseText);
                location.reload();
            } else {
                alert('Ein Fehler ist aufgetreten.');
            }
        };

        var postData = selectedDevices.map((id, index) => `deviceIds[]=${id}`).join('&');
        xhr.send(postData);
    });

    document.getElementById('lagergeraetForm').addEventListener('submit', function (e) {
        e.preventDefault();
    
        var formData = new FormData(this);
        
        var dropdown = document.getElementById('sortimentDropdown');
        var selectedOption = dropdown.options[dropdown.selectedIndex];
        var seriennummer = selectedOption.getAttribute('data-seriennummer');
        
        formData.append('SortimentID', selectedOption.value);
        formData.append('Seriennummer', seriennummer);
    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_lagergeraet.php', true);
        xhr.onload = function () {
            var response = JSON.parse(this.responseText);
            alert(response.message);
            if (response.status === "success") {
                document.getElementById('lagergeraetForm').reset();
            }
        };
        xhr.send(formData);
    });
    

    function loadLagerGeraete() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_lagergeraete.php', true);
        xhr.onload = function () {
            if (this.status == 200) {
                try {
                    var lagergeraete = JSON.parse(this.responseText);
                    var output = '';
                    
                    for (var i in lagergeraete) {
                        output += '<tr>';
                        output += '<td><input type="checkbox" class="deviceCheckbox" data-id="' + lagergeraete[i].LagergeraetID + '"></td>';
                        output += '<td>' + lagergeraete[i].MarkenName + '</td>';
                        output += '<td>' + lagergeraete[i].Modell + '</td>';
                        output += '<td>' + lagergeraete[i].Geraetetyp + '</td>';
                        output += '<td>' + lagergeraete[i].Seriennummer + '</td>';
                        output += '<td>' + lagergeraete[i].Verkaufspreis + '</td>';
                        output += '<td>' + (lagergeraete[i].Verkauft ? 'Ja' : 'Nein') + '</td>';
                        output += '</tr>';
                    }
                    
                    document.getElementById('lagerGeraeteList').innerHTML = output;
                } catch (e) {
                    console.error("JSON parsing failed:", e);
                }
            }
        };
        xhr.send();
    }

    
    document.getElementById('updateStatusButton').addEventListener('click', function () {
        var checkboxes = document.querySelectorAll('.deviceCheckbox:checked');
        var selectedIds = [];
        checkboxes.forEach(function (box) {
            selectedIds.push(box.getAttribute('data-id'));
        });
    
        if (selectedIds.length === 0) {
            alert('Bitte wählen Sie mindestens ein Gerät aus.');
            return;
        }
    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_sold_status.php', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (this.status === 200) {
              
                location.reload();
            } else {
                alert('Ein Fehler ist aufgetreten.');
            }
        };
        xhr.send('deviceIds=' + JSON.stringify(selectedIds));
    });
    
});


function loadSoldDevices() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_sold_devices.php', true); 
    xhr.onload = function () {
        if (this.status == 200) {
            try {
                var soldDevices = JSON.parse(this.responseText);
                var output = '';
                
                for (var i in soldDevices) {
                    output += '<tr>';
                    output += '<td><input type="checkbox" class="soldDeviceCheckbox" data-id="' + soldDevices[i].LagergeraetID + '"></td>';
                    output += '<td>' + soldDevices[i].MarkenName + '</td>';
                    output += '<td>' + soldDevices[i].Modell + '</td>';
                    output += '<td>' + soldDevices[i].Geraetetyp + '</td>';
                    output += '<td>' + soldDevices[i].Seriennummer + '</td>';
                    output += '<td>' + soldDevices[i].Verkaufspreis + '</td>';
                    output += '<td>Ja</td>'; 
                    output += '</tr>';
                }
                
                document.getElementById('soldDeviceTableBody').innerHTML = output;
            } catch (e) {
                console.error("JSON parsing failed:", e);
            }
        }
    };
    xhr.send();
}

document.getElementById('deleteLagerButton').addEventListener('click', function () {
    var checkboxes = document.querySelectorAll('.deviceCheckbox:checked');
    var selectedIds = [];
    checkboxes.forEach(function (box) {
        selectedIds.push(box.getAttribute('data-id'));
    });

    if (selectedIds.length === 0) {
        alert('Bitte wählen Sie mindestens ein Gerät aus.');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_lagergeraet.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (this.status === 200) {
            try {
                var response = JSON.parse(this.responseText);
                if (response.success) {
                    checkboxes.forEach(function (box) {
                        box.closest('tr').remove();
                    });
                } else {
                    alert('Ein Fehler ist aufgetreten beim Löschen der Geräte.');
                }
            } catch (e) {
                console.error("JSON parsing failed:", e);
                alert('Ein Fehler ist aufgetreten.');
            }
        } else {
            alert('Ein Fehler ist aufgetreten.');
        }
    };
    xhr.send('deviceIds=' + JSON.stringify(selectedIds));
});


document.getElementById('deleteVerkauftButton').addEventListener('click', function() {
    var checkboxes = document.querySelectorAll('.soldDeviceCheckbox:checked');
    var selectedIds = [];
    checkboxes.forEach(function(box) {
        selectedIds.push(box.getAttribute('data-id'));
    });

    if (selectedIds.length === 0) {
        alert('Bitte wählen Sie mindestens ein verkauftes Gerät aus.');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_sold_device.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (this.status === 200) {
            loadSoldDevices();  
        } else {
            alert('Ein Fehler ist aufgetreten.');
        }
    };
    xhr.send('deviceIds=' + JSON.stringify(selectedIds));
});
