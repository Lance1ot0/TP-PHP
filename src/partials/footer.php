        <div class="css-bg" >
                <ul class="circles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                </ul>
        </div >
    
        <script>
            console.log("test");
            const cursor = document.querySelector(".cursor");
            let timeout;

            mouseStopped = () => {
                cursor.style.display = "none";
            }

            document.addEventListener("mousemove", (e) => {
                let x = e.pageX;
                let y = e.pageY;

                cursor.style.top = y + "px";
                cursor.style.left = x + "px";
                cursor.style.display = "block";

                clearTimeout(timeout)
                timeout = setTimeout(mouseStopped, 1000);
            })

            document.addEventListener("mouseout", () => {
                cursor.style.display = "none";
            });
        </script>
    </body>

   
</html>