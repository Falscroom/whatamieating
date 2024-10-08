import {useQuery} from 'vue-query';
import {useFetchUsers} from '@infrastructure/api';

export const useUserQuery = () => {
    return useQuery('users', useFetchUsers);
}
