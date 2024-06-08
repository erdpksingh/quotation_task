<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Inline form</h2>
  <form class="form-inline" id='quotation' action="/action_page.php">
    <div class="form-group">
      <label for="age">Age:</label>
      <input type="text" class="form-control" id="age" placeholder="Enter age" name="age">
      <div id="error_message_age" class="text-danger mt-2" style="display: none;">
               Please enter age.
        </div>
    </div>

    <div class="form-group">
    <label for="currency">Currency:</label>
    <select form-control id="currency_id" name="currency_id">
    <option form-control value=" ">Select Currency</option>
    <option form-control value="eur">EUR</option>
    <option form-control value="gbp">GBP</option>
    <option form-control value="usd">USD</option>
    <option form-control value="aed">AED</option>
  </select>
  <div id="error_message_currency" class="text-danger mt-2" style="display: none;">
                    Please select currency.
        </div>
    </div>

    
    <div class="form-group">
      <label for="date">Start Date:</label>
      <input type="date" class="form-control" id="start_date" placeholder="Enter Start Date" name="pwd">
      <div id="start_date_error" class="text-danger mt-2" style="display: none;">
                    Please select start_date.
        </div>
    </div>

    <div class="form-group">
      <label for="pwd">End Date:</label>
      <input type="date" class="form-control" id="end_date" placeholder="Enter End Date" name="pwd">
      <div id="end_date_error" class="text-danger mt-2" style="display: none;">
                    Please select end_date.
        </div>
    </div>


    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>
<div id='result'></div>
</body>
<script>
        document.getElementById('quotation').addEventListener('submit', async function (event) {
            event.preventDefault();
            const age = document.getElementById('age').value;
            const currency_id = document.getElementById('currency_id').value;
            const start_date = document.getElementById('start_date').value;
            const end_date = document.getElementById('end_date').value;
            
            try {

              const errorMessageage = document.getElementById('error_message_age');
              const error_message_currency = document.getElementById('error_message_currency');
              const start_date_error = document.getElementById('start_date_error');
              const end_date_error = document.getElementById('end_date_error');
             
              if (age === '') {
                errorMessageage.style.display = 'block';
                    return;
                } else {
                  errorMessageage.style.display = 'none';
                }

                if (currency_id === " " || currency_id === null) {
                  error_message_currency.style.display = 'block';
                    return;
                } else {
                  error_message_currency.style.display = 'none';
                }

                if (start_date === "" || start_date === null) {
                  start_date_error.style.display = 'block';
                    return;
                } else {
                  start_date_error.style.display = 'none';
                }

                if (end_date === "" || end_date === null) {
                  end_date_error.style.display = 'block';
                    return;
                } else {
                  end_date_error.style.display = 'none';
                }
             

                const response = await fetch('/api/quotation', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                      //  'Authorization': `Bearer ${token}`,
                    },
                    body: JSON.stringify({ age, currency_id, start_date, end_date})
                });

                const result = await response.json();
                
                if (result.status === 'success') {

                    document.getElementById('result').innerHTML = `
                        <table class="table table-bordered">
                        <tr>
                        <th>Total</th>
                        <th>Currency</th>
                        <th>Quotation Id</th>
                        </tr>
                    <tr>
                        <td>${result.total}</td>
                        <td>${result.currency_id}</td>
                        <td>QTNo.${result.quotation_id}</td>
                    </tr>
                        </table>    
                    `;                  
                } else {


                   console.log('Error');

                }
            } catch (error) {
               const errorMessage = error.message;
               console.log(errorMessage);
            }
        });
    </script>
</html>
