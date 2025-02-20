<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Distribution</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h1>Card Distribution to Players</h1>

    <form id="cardForm">
        <label for="num_players">Enter Number of Players (1 to 52):</label>
        <input type="number" id="num_players" name="num_players" min="1" max="52" required>
        <button type="submit">Distribute Cards</button>
    </form>

    <div id="cards_output"></div>

    <script>
        $("#cardForm").on("submit", function(event) {
            event.preventDefault();

            const numPlayers = $("#num_players").val();

            $.ajax({
                    url: '/distribute_cards', 
                    method: 'POST',
                    data: { num_players: numPlayers },
                    success: function(response) {
                        const data = JSON.parse(response);
                    
                        if (data.error) {
                            alert("Irregularity occurred");
                        } else {
                            let output = "<h2>Distributed Cards:</h2>";
                            data.forEach((playerCards, index) => {
                                output += `<p>Player ${index + 1}: ${playerCards}</p>`;
                            });
                            $("#cards_output").html(output);
                        }
                    },
                    error: function() {
                        alert("An error occurred while distributing the cards.");
                    }
                });
        });
    </script>

</body>
</html>