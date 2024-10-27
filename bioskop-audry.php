<?php
// Function to calculate total price and return details
function calculate_total_price($adult_tickets, $child_tickets, $day_of_booking) {
    // Define ticket prices
    $adult_ticket_price = 50000;
    $child_ticket_price = 30000;
    $weekend_surcharge = 10000;

    // Calculate base total
    $base_total = ($adult_tickets * $adult_ticket_price) + ($child_tickets * $child_ticket_price);

    // Calculate weekend surcharge
    $surcharge = 0;
    if ($day_of_booking == "Sabtu" || $day_of_booking == "Minggu") {
        $surcharge = ($adult_tickets + $child_tickets) * $weekend_surcharge;
    }

    $total_before_discount = $base_total + $surcharge;

    // Calculate discount if total price exceeds 150000
    $discount = 0;
    if ($total_before_discount > 150000) {
        $discount = $total_before_discount * 0.1; // 10% discount
    }

    $total_after_discount = $total_before_discount - $discount;

    return [
        'base_total' => $base_total,
        'surcharge' => $surcharge,
        'total_before_discount' => $total_before_discount,
        'discount' => $discount,
        'total_after_discount' => $total_after_discount
    ];
}

// HTML form for user input
echo "<div class='container'>";
echo "<h2>Pemesanan Tiket Bioskop</h2>";
echo "<form method='post' action='' class='form-inputs'>";

echo "<label for='adult_tickets'>Jumlah Tiket Dewasa:</label>";
echo "<input type='number' id='adult_tickets' name='adult_tickets' min='0' value='0' class='form-control'>";

echo "<label for='child_tickets'>Jumlah Tiket Anak-anak:</label>";
echo "<input type='number' id='child_tickets' name='child_tickets' min='0' value='0' class='form-control'>";

echo "<label for='day_of_booking'>Hari Pemesanan:</label>";
echo "<select id='day_of_booking' name='day_of_booking' class='form-control'>";
echo "<option value=''>Pilih Hari</option>";
echo "<option value='Senin'>Senin</option>";
echo "<option value='Selasa'>Selasa</option>";
echo "<option value='Rabu'>Rabu</option>";
echo "<option value='Kamis'>Kamis</option>";
echo "<option value='Jumat'>Jumat</option>";
echo "<option value='Sabtu'>Sabtu</option>";
echo "<option value='Minggu'>Minggu</option>";
echo "</select>";

echo "<button type='submit' class='btn btn-primary mt-3'>Hitung Total</button>";
echo "</form>";

// Input from user
$adult_tickets = isset($_POST['adult_tickets']) ? (int)$_POST['adult_tickets'] : 0;
$child_tickets = isset($_POST['child_tickets']) ? (int)$_POST['child_tickets'] : 0;
$day_of_booking = isset($_POST['day_of_booking']) ? $_POST['day_of_booking'] : "";

// Calculate total price if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($day_of_booking)) {
    $pricing_details = calculate_total_price($adult_tickets, $child_tickets, $day_of_booking);

    // Output the pricing details in a receipt-like format
    echo "<hr>";
    echo "<div class='receipt'>";
    echo "<h3>Struk Pemesanan Tiket</h3>";
    echo "<div><span>Jumlah Tiket Dewasa:</span> <span>$adult_tickets x Rp" . number_format(50000, 0, ',', '.') . "</span></div>";
    echo "<div><span>Jumlah Tiket Anak-anak:</span> <span>$child_tickets x Rp" . number_format(30000, 0, ',', '.') . "</span></div>";
    if ($pricing_details['surcharge'] > 0) {
        echo "<div><span>Biaya Tambahan Hari Libur:</span> <span>Rp" . number_format($pricing_details['surcharge'], 0, ',', '.') . "</span></div>";
    }
    if ($pricing_details['discount'] > 0) {
        echo "<div><span>Total Sebelum Diskon:</span> <span>Rp" . number_format($pricing_details['total_before_discount'], 0, ',', '.') . "</span></div>";
        echo "<div><span>Diskon 10%:</span> <span>-Rp" . number_format($pricing_details['discount'], 0, ',', '.') . "</span></div>";
        echo "<div class='total'><span>Total:</span> <span>Rp" . number_format($pricing_details['total_after_discount'], 0, ',', '.') . "</span></div>";
    } else {
        echo "<div class='total'><span>Total:</span> <span>Rp" . number_format($pricing_details['total_before_discount'], 0, ',', '.') . "</span></div>";
    }
    echo "<form method='post' action='' class='form-receipt'>";
    echo "<input type='hidden' name='adult_tickets' value='$adult_tickets'>";
    echo "<input type='hidden' name='child_tickets' value='$child_tickets'>";
    echo "<input type='hidden' name='day_of_booking' value='$day_of_booking'>";
    echo "<button type='submit' class='btn btn-success mt-3'>Pesan Sekarang</button>";
    echo "</form>";
    echo "</div>";
}

echo "</div>";
?>

<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
