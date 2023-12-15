<div>
    <button type="button" wire:click="clockState" class="btn btn-primary" name="button">
        <span id="currentTime"></span>
    </button>
    <!--still working on setting up "min" in a different container to keep it from bouncing around as the time resizes-->
    @section('style')
    @parent
    <style>
        @import url(https://fonts.googleapis.com/css?family=Oswald:300,400);

        body {
            background-color: #222;
        }

        #currentTime {
            font-size: 10em;
            text-align: center;
            font-family: 'Oswald';
            font-weight: 300;
            color: #f05b19;
            margin: 100px auto;
        }
    </style>
    @stop
    @section('script')
    @parent
    <script>
        window.onload = function () {
            clock();
            function clock() {
                var now = new Date();
                var TwentyFourHour = now.getHours();
                var hour = now.getHours();
                var min = now.getMinutes();
                var sec = now.getSeconds();
                var mid = 'pm';
                if (min < 10) {
                    min = "0" + min;
                }
                if (@this.clockState) {
                    if (hour > 12) {
                        hour = hour - 12;
                    }
                }
                if (hour == 0) {
                    hour = 12;
                }
                if (TwentyFourHour < 12) {
                    mid = 'am';
                }
                document.getElementById('currentTime').innerHTML = hour + ':' + min + ':' + sec + ' ' + mid;
                setTimeout(clock, 1000);
            }
        }

    </script>
    @stop
</div>