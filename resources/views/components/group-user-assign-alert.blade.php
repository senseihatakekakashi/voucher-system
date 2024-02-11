<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add click event listener to all delete buttons
        document.querySelectorAll('.group-user-assign-button').forEach(function(button) {
            button.addEventListener('click', function() {
                var formId = 'groupUserAssignForm' + this.getAttribute('data-id');
                var form = document.getElementById(formId);

                Swal.fire({
                    title: "Voucher System",
                    text: "Are you sure to assign this User to this group?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonText: "Confirm User Assignment",
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