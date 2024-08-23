<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wireless Print Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Wireless Print Demo</h1>
        <form id="printForm">
            @csrf
            <div class="mb-3">
                <label for="printer" class="form-label">Select Printer</label>
                <select class="form-select" id="printer" name="printer_id" required>
                    @foreach($printers as $printer)
                        <option value="{{ $printer->id }}">{{ $printer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="customer_name" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div id="items">
                <div class="item mb-3">
                    <input type="text" class="form-control mb-2" name="items[0][name]" placeholder="Item Name" required>
                    <input type="number" class="form-control mb-2" name="items[0][price]" placeholder="Price" step="0.01" required>
                    <input type="number" class="form-control mb-2" name="items[0][quantity]" placeholder="Quantity" required>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" id="addItem">Add Item</button>
            <button type="submit" class="btn btn-primary">Print Receipt</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let itemCount = 1;

            $('#addItem').click(function() {
                const newItem = `
                    <div class="item mb-3">
                        <input type="text" class="form-control mb-2" name="items[${itemCount}][name]" placeholder="Item Name" required>
                        <input type="number" class="form-control mb-2" name="items[${itemCount}][price]" placeholder="Price" step="0.01" required>
                        <input type="number" class="form-control mb-2" name="items[${itemCount}][quantity]" placeholder="Quantity" required>
                    </div>
                `;
                $('#items').append(newItem);
                itemCount++;
            });

            $('#printForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('send.to.printer') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
</body>
</html>