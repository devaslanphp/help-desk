<div style="display: flex; flex-direction: row;" x-data="{ activeTab: 'content1' }">
    <div id="sidebar" style="left: 0px; top: 80px; margin: 0; padding: 0; width: 200px; background-color: #f1f1f1; position: fixed; height: 100%; overflow: auto;">
        <a style="display: block; color: black; padding: 16px; text-decoration: none;">
            <button @click="activeTab = 'content1'">Not assigned tickets</button>
        </a>
        <a style="display: block; color: black; padding: 16px; text-decoration: none;">
            <button @click="activeTab = 'content2'">My assigned tickets</button>
        </a>
        <a style="display: block; color: black; padding: 16px; text-decoration: none;">
            <button @click="activeTab = 'content3'">Tickets by statuses</button>
        </a>
        <a style="display: block; color: black; padding: 16px; text-decoration: none;">
            <button @click="activeTab = 'content4';">Tickets assignments</button>
        </a>
        <a style="display: block; color: black; padding: 16px; text-decoration: none;">
            <button @click="activeTab = 'content5';">Ticket Trends</button>        </a>
    </div>
    <script>

        // JavaScript to handle button clicks
        document.getElementById('button1').addEventListener('click', function() {
        // Hide all content sections
        hideAllContent();

        // Show content for Button 1
        document.getElementById('content1').style.display = 'block';
        });

        document.getElementById('button2').addEventListener('click', function() {
        // Hide all content sections
        hideAllContent();

        // Show content for Button 2
        document.getElementById('content2').style.display = 'block';
        });

        document.getElementById('button3').addEventListener('click', function() {
        // Hide all content sections
        hideAllContent();

        // Show content for Button 3
        document.getElementById('content3').style.display = 'block';
        });

       
        // Function to hide all content sections
        function hideAllContent() {
        document.getElementById('content1').style.display = 'none';
        document.getElementById('content2').style.display = 'none';
        document.getElementById('content3').style.display = 'none';
        // Add more lines for other content sections if needed
        }

    </script>
</div>