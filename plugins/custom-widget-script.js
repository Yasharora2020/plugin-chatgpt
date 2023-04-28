document.getElementById('custom-widget-submit').addEventListener('click', function() {
    let inputElement = document.getElementById('custom-widget-input');
    let loadingElement = document.getElementById('custom-widget-loading');

    let inputText = inputElement.value.trim();
    if (inputText !== '') {
        loadingElement.classList.remove('hidden');

        // Replace this part with your actual backend URL and parameters
        $.ajax({
            url: "https://abcdefghu.execute-api.ap-southeast-2.amazonaws.com/dev/question",
            method: "POST",
            data: JSON.stringify({ input_text: inputText }),
            contentType: "application/json",
            success: function (response) {
                console.log(response);
                document.getElementById('custom-widget-response').innerHTML = '<div class="answer">' + response.body + '</div>';
                loadingElement.classList.add('hidden');
            },
            error: function (error) {
                console.log(error);
                loadingElement.classList.add('hidden');
            }
        });
    }
});