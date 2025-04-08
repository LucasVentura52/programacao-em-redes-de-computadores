document.getElementById("commandForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const command = document.getElementById("commandInput").value;

    fetch("process_command.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "command=" + encodeURIComponent(command)
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("modalResponse").innerText = data;
        const responseModal = new bootstrap.Modal(document.getElementById("responseModal"));
        responseModal.show();
    })
    .catch(error => {
        document.getElementById("modalResponse").innerText = "Erro ao conectar ao servidor.";
        const responseModal = new bootstrap.Modal(document.getElementById("responseModal"));
        responseModal.show();
    });
});