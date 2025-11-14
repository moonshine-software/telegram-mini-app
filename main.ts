import { init, retrieveRawInitData } from '@telegram-apps/sdk';
import { isTMA } from '@telegram-apps/bridge';
import axios from 'axios';

if (isTMA()) {
    init();

    const url = document.querySelector('meta[name="url"]').getAttribute('content');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    axios.post(url, {}, {
        headers: {
            'X-Authorization': `tma ${retrieveRawInitData()}`,
            'X-CSRF-TOKEN': token
        },
    })
        .then(response => {
            return response.data
        })
        .then(data => {
            window.location.href = data.url;
        })
        .catch(error => {
            alert(error.data.message);
        });
} else {
    alert('The request is not from the Telegram mini app.');
}

