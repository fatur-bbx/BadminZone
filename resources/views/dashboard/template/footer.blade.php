<div class="container-xl px-4">
    <div class="row">
        <div class="col-md-6 small">Copyright &copy; Your Website 2021</div>
        <div class="col-md-6 text-md-end small">
            <a href="#!">Privacy Policy</a>
            &middot;
            <a href="#!">Terms &amp; Conditions</a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

        function showModalWithCountdown(modalId, message) {
            let countdown = 3;
            const modalElement = $(modalId);
            const countdownElement = modalElement.find('.countdown');

            function updateCountdown() {
                countdownElement.text(`${countdown} detik...`);
                countdown--;

                if (countdown < 0) {
                    modalElement.modal('hide');
                }
            }

            modalElement.modal('show');
            countdownElement.text(`${countdown} detik...`);
            setInterval(updateCountdown, 1000);
        }

        @if(session('success'))
            showModalWithCountdown('#successModal', "{{ session('success') }}");
        @endif

        @if(session('error'))
            showModalWithCountdown('#errorModal', "{{ session('error') }}");
        @endif
    });
</script>

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
            </div>
            <div class="modal-body">
                {{ session('success') }}
            </div>
            <div class="modal-footer">
                <p>Notifikasi akan ditutup dalam <span class="countdown">3 detik...</span></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
            </div>
            <div class="modal-body">
                {{ session('error') }}
            </div>
            <div class="modal-footer">
                <p>Notifikasi akan ditutup dalam <span class="countdown">3 detik...</span></p>
            </div>
        </div>
    </div>
</div>