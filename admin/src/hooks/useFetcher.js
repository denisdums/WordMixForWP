import {useState} from "react";

export default function useFetcher() {
    const [loading, setLoading] = useState(false);
    const [data, setData] = useState(null);

    const fetcher = async (url, options) => {
        const fullUrl = window.wordmix.root + url;
        setLoading(true);
        try {
            const response = await fetch(fullUrl, {
                headers: {
                    'X-WP-Nonce': window.wordmix.nonce,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                ...options,
            });
            const data = await response.json();
            setData(data);
        } catch (error) {
            console.error(error);
            setData(null);
        } finally {
            setLoading(false);
        }
    };

    return [fetcher, data, loading];
};