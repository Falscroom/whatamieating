export const useBaseApiUrl = () => {
    // @todo перенести в env
    const baseUrl = 'https://freetestapi.com/api';
    const apiVersion = 'v1';

    const url = `${baseUrl}/${apiVersion}`;

    return {
        baseUrl: url,
    };
}
