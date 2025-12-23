document.getElementById('logButton').addEventListener('click', function() {
    fetch('/php/log-info.php')
        .then(response => response.text())
        .then(data => {
            alert(data);
        })
        .catch(error => console.error('Error:', error));
});
