import {useBaseApiUrl} from '@infrastructure/api/useBaseApiUrl';
import {ref} from 'vue';
import {User} from '@shared/interface';

export const useFetchUsers = async (): Promise<User[]> => {
    const {baseUrl} = useBaseApiUrl();

    const data = ref<User[]>();

    await fetch(`${baseUrl}/users`)
        .then((res) => res.json())
        .then((res) => data.value = res)
        .catch((error) => {
            console.error('Error useFetchUsers')
            throw error;
        })

    return data;
};
