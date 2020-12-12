    </div>
</section>

    <?php if(isset($datatable)): ?>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.dt').DataTable();
            });
        </script>
    <?php endif; ?>

<?php include_once 'footer.view.php'; ?>