
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showSection(name) {
            document
                .querySelectorAll(".demo-section")
                .forEach((s) => s.classList.remove("active"));
            document
                .querySelectorAll(".nav-demo-btn")
                .forEach((b) => b.classList.remove("active"));
            document.getElementById("section-" + name).classList.add("active");
            event.target.classList.add("active");
        }
    </script>
</body>

</html>