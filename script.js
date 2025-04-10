document.addEventListener("DOMContentLoaded", function () {
    const roomSelectButtons = document.querySelectorAll('input[name="room_selection"]');
    const bookNowButton = document.getElementById("bookNowButton");
    const selectedRoomInput = document.getElementById("selected_room");

    // Event listener für Auswahl des Zimmers
    roomSelectButtons.forEach(button => {
        button.addEventListener("change", function () {
            // Set the selected room number in the hidden input field
            selectedRoomInput.value = this.value;

            // Check if room and dates are selected, and enable the "Book Now" button
            const checkInDate = document.getElementById("check_in_date").value;
            const checkOutDate = document.getElementById("check_out_date").value;

            // Enable the "Book Now" button if all required fields are filled
            if (selectedRoomInput.value && checkInDate && checkOutDate) {
                bookNowButton.disabled = false;
            } else {
                bookNowButton.disabled = true;
            }
        });
    });
});

// When a room is selected, set the hidden fields
const roomRadios = document.querySelectorAll('input[name="room_selection"]');
roomRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        const selectedRoom = this.value;
        const selectedRoomType = this.closest('tr').querySelector('td:nth-child(2)').textContent; // Get room type from the second column
        document.getElementById('selected_room').value = selectedRoom;
        document.getElementById('selected_room_type').value = selectedRoomType; // Set room type in the hidden field

        // Enable the "Book Now" button when a room is selected
        document.getElementById('bookNowButton').disabled = false;
    });
});