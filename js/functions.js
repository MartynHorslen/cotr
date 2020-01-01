// function fetch(url, {
//     method: 'POST',
//     headers: {
//         'Content-type': 'application/json',
//         'apikey': apiKey
//         },
//     body: data
//     }).then(response => {
//     if (response.ok) {
//         return response.json();
//     }
//     throw new Error('Request failed!');
//     }, networkError => console.log(networkError.message))
//     .then(jsonResponse => {
//     renderJsonResponse(jsonResponse);
// });


// const renderJsonResponse = (response) => {
//     // Creates an empty object to store the JSON in key-value pairs
//     let rawJson = {}
//     for(let key in response){
//       rawJson[key] = response[key]
//     }
//     // Converts JSON into a string and adding line breaks to make it easier to read
//     rawJson = JSON.stringify(rawJson).replace(/,/g, ", \n")
//     // Manipulates responseField to show the returned JSON.
//     responseField.innerHTML = `<pre>${rawJson}</pre>`
// }

function reply() {
    var replyContent = $("#reply-content").val();
    var userId = $("#user-id").val();
    var topicId = $("#topic-id").val();

    if (replyContent === "" )
    {
        alert("Please fill in the reply field");
    } else {
        $.ajax({
            async: true,
            type: 'POST',
            //cache: false,
            url: 'reply.php',
            data: {
                replyContent:replyContent,
                userId:userId,
                topicId:topicId
            },
            success: function(response) {
                console.log("Reply posted successfully");
            },
            error: function(response) {
                alert('Error: ', response);
            }
        });
    }
}

function createTopic() {
    var topicSubject = $("#topic_subject").val();
    var topicCat = $("#topic_cat").val();
    var postContent = $("#post_content").val();
    var userId = $("#user-id").val();

    if (topicSubject === "" || postContent === "" )
    {
        alert("Please fill in the fields");
    } else {
        $.ajax({
            async: true,
            type: 'POST',
            //cache: false,
            url: 'create_topic.php',
            data: {
                userId:userId,
                topicSubject:topicSubject,
                topicCat:topicCat,
                postContent:postContent
            },
            success: function(response) {
                window.location.assign(response);
            },
            error: function(response) {
                alert('Error: ', response);
            }
        });
    }
}