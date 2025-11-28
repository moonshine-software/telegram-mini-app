import { init, retrieveRawInitData, disableVerticalSwipes } from '@telegram-apps/sdk';
import { isTMA } from '@telegram-apps/bridge';
import axios from 'axios';

if (isTMA()) {
    init();

    const url = document.querySelector('meta[name="url"]').getAttribute('content');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const configDisableVerticalSwipesValue = document.querySelector('meta[name="config-disable_vertical_swipes"]').getAttribute('content');
    console.log('configDisableVerticalSwipesValue', configDisableVerticalSwipesValue);
    if (configDisableVerticalSwipesValue) {
        disableVerticalSwipes();
    }
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

