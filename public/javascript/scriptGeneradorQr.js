if(document.documentElement.lang === "es"){
    const btnsGenerar = document.querySelectorAll('.btnGenerar');
    btnsGenerar.forEach(btnGenerar => {
        btnGenerar.addEventListener('click', () =>{
            const div = document.createElement('div');
            div.style.display = 'flex';
            div.style.alignItems = 'center';
            div.style.justifyContent = 'center';
            div.style.flexDirection = 'column';
            let codigo = btnGenerar.getAttribute("data-codigo");
    
            const btnDescargar = document.createElement("a");
            btnDescargar.className = "descargar";
            btnDescargar.textContent = 'Descargar';
            btnDescargar.addEventListener('click', () => {
                html2canvas(div).then(canvas => {
                    const imageData = canvas.toDataURL('image/png');
    
                    const link = document.createElement('a');
                    link.href = imageData;
                    link.download = `${codigo}.png`;
    
                    link.click();
                });
            });
    
            const info = document.createElement('div');
            const h1 = document.createElement('h1');
            h1.style.color = 'black';
            h1.textContent = 'QuickCarry';
    
            const textCodigo = document.createElement('div');
            textCodigo.style.color = 'black';
            textCodigo.textContent = `Codigo: ${codigo}`;
            info.appendChild(h1);
            info.appendChild(document.createElement('br'));
            info.appendChild(textCodigo);
            info.appendChild(document.createElement('br'));
    
            div.appendChild(info);
    
            const descargar = document.createElement('div');
            descargar.appendChild(btnDescargar);
    
            new QRCode(div, codigo);
    
            Swal.fire({
                title: div,
                html: descargar,
                confirmButtonText: 'Cerrar',
                confirmButtonColor: 'crimson'
            });
        })
    });
}else{
    const btnsGenerar = document.querySelectorAll('.btnGenerar');
    btnsGenerar.forEach(btnGenerar => {
        btnGenerar.addEventListener('click', () =>{
            const div = document.createElement('div');
            div.style.display = 'flex';
            div.style.alignItems = 'center';
            div.style.justifyContent = 'center';
            div.style.flexDirection = 'column';
            let codigo = btnGenerar.getAttribute("data-codigo");
    
            const btnDescargar = document.createElement("a");
            btnDescargar.className = "descargar";
            btnDescargar.textContent = 'Download';
            btnDescargar.addEventListener('click', () => {
                html2canvas(div).then(canvas => {
                    const imageData = canvas.toDataURL('image/png');
    
                    const link = document.createElement('a');
                    link.href = imageData;
                    link.download = `${codigo}.png`;
    
                    link.click();
                });
            });
    
            const info = document.createElement('div');
            const h1 = document.createElement('h1');
            h1.style.color = 'black';
            h1.textContent = 'QuickCarry';
    
            const textCodigo = document.createElement('div');
            textCodigo.style.color = 'black';
            textCodigo.textContent = `Code: ${codigo}`;
            info.appendChild(h1);
            info.appendChild(document.createElement('br'));
            info.appendChild(textCodigo);
            info.appendChild(document.createElement('br'));
    
            div.appendChild(info);
    
            const descargar = document.createElement('div');
            descargar.appendChild(btnDescargar);
    
            new QRCode(div, codigo);
    
            Swal.fire({
                title: div,
                html: descargar,
                confirmButtonText: 'Close',
                confirmButtonColor: 'crimson'
            });
        })
    });
}