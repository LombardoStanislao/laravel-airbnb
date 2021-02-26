console.log('js attivo');
let userId = document.getElementsByName('user')[0].value;
console.log(userId);
if (!isNaN(userId) || !userId) {
    userId = parseInt(userId);

    let apartmentId = document.getElementsByName('apartment')[0].value;
    if (!isNaN(apartmentId)) {
        apartmentId = parseInt(apartmentId);
        axios({
            method: 'post',
            url: 'http://localhost:8000/api/addView',
            data: {
                userId,
                apartmentId
            }
        });

    }
}
