   <?php
        if (isset($_GET['error'])) {
            ?>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    
                    const errorMsg = document.createElement("p");
                    errorMsg.className = "text-red-500 mb-4";
                    errorMsg.textContent = "<?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>";
                    document.querySelector("main").prepend(errorMsg);
                    setTimeout(() => {
                        errorMsg.remove();
                    }, 5000);
                });
            </script>
            <?php
        }

        if (isset($_GET['message'])) {
            ?>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const Msg = document.createElement("p");
                    Msg.className = "text-green-500 mb-4";
                    Msg.textContent = "<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>";
                    document.querySelector("main").prepend(Msg);
                    setTimeout(() => {
                        Msg.remove();
                    }, 5000);
                });
            </script>
            <?php
        }
    ?>