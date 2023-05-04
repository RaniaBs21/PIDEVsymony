function countdown() {
    const startingTime = 10; // change this to the desired starting time
    let time = startingTime;

    const countdownElement = document.getElementById("countdown");

    const countdownInterval = setInterval(() => {
        if (time <= 0) {
            clearInterval(countdownInterval);
            // handle timeout here
        } else {
            countdownElement.innerHTML = time;
            time--;
        }
    }, 1000);
}
