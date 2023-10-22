
document.addEventListener("DOMContentLoaded", function() {
    fetchProducts();
});

function fetchProducts() {
    fetch('/intern/Verkauf/fetch_devices.php')
    .then(response => response.json())
    .then(data => {
        displayProducts(data);
    })
    .catch(error => {
        console.error("Es gab ein Problem beim Abrufen der Daten:", error);
    });
}

function displayProducts(products) {
    const productsContainer = document.getElementById('products');

    products.forEach(product => {
        const productDiv = document.createElement('div');
        productDiv.className = 'product';

        const productInfo = `
            <h2>${product.MarkenName} ${product.Modell}</h2>
            <p>Typ: ${product.Typ}</p>
            <p>Preis: ${product.Verkaufspreis} CHF</p>
            <p>Lagerbestand: ${product.Lagerbestand}</p>
            <img src="${product.Bildpfad}" alt="${product.MarkenName} ${product.Modell}" />
        `;

        productDiv.innerHTML = productInfo;

       
        const descriptionDiv = document.createElement('div');
        descriptionDiv.className = 'description-kachel';

       
        const descriptionLines = product.Beschreibung.split('\n');
        const ul = document.createElement('ul');
        descriptionLines.forEach(line => {
            if(line.trim() !== "") {
                const li = document.createElement('li');
                li.textContent = line.trim();
                ul.appendChild(li);
            }
        });
        descriptionDiv.appendChild(ul);

      
        productDiv.appendChild(descriptionDiv);
        
    
        productsContainer.appendChild(productDiv);
    });
}


