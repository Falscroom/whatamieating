export const useBaseApiUrl = () => {
    // @todo перенести в env
    const baseUrl = 'https://jsonplaceholder.typicode.com';

    const url = `${baseUrl}`;

    return {
        baseUrl: url,
    };
}
