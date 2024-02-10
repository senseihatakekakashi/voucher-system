<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add click event listener to all delete buttons
        document.querySelectorAll('.delete-button').forEach(function(button) {
            button.addEventListener('click', function() {
                var formId = 'deleteForm' + this.getAttribute('data-id');
                var form = document.getElementById(formId);

                Swal.fire({
                    title: "Voucher System",
                    text: "Are you sure to remove/delete this? You will not be able to revert this action!",
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonText: "Confirm Delete",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form if the user confirms
                        form.submit();
                    }
                });
            });
        });
    });
</script>