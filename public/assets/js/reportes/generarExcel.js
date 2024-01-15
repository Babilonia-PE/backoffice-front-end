const inputCSV = document.getElementById("inputCSV");

const sendDataToEndpoint = (data) => {
    fetch('tu_endpoint', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ csvData: data }),
    })
      .then(response => response.json())
      .then(result => {
        console.log('Resultado del servidor:', result);
      })
      .catch(error => {
        console.error('Error al enviar datos:', error);
      });
}

const processData = (csvContent) => {
    const lines = csvContent.split('\n');
    if(lines.length == 0) return [];
    
    lines.shift();

    let response = lines
                    .map((item)=> ({...item.split(",")}))
                    .map((item)=> parseInt(item[0]));

    return response;
}

inputCSV.addEventListener('change', function(e){
    const file = e.target.files[0];
    const name = file?.name ?? 'Seleccione CSV';
    e.target.parentElement.querySelector(".custom-file-label").innerHTML=name;        
});

document.querySelector(".card-body form").addEventListener('submit', function(e){
    e.preventDefault();

    const file = inputCSV.files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
        const csvContent = e.target.result;
        const data = processData(csvContent);
        console.log(data);
        //sendDataToEndpoint(data);
    };

    reader.readAsText(file);
    
});