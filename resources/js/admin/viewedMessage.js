let messageId = document.getElementById('message-page').dataset.messageId;
console.log(messageId);

axios({
    method: 'post',
    url: 'http://localhost:8000/api/viewedMessage',
    data: {
        messageId
    }
}).then(response => {
    console.log(response.data);
});
