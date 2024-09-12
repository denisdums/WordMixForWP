import React, {useEffect, useState} from "react";
import useFetcher from "./useFetcher";

export default function useOption(key) {
    const [value, setValue] = useState();
    const [saveFetcher, saveData, saveLoading] = useFetcher();
    const [getFetcher, getData, getLoading] = useFetcher();
    const updateValue = (input) => {
        setValue(input)
        saveFetcher('wordmix/save-option/', {
            method: 'POST', body: JSON.stringify({option_name: key, option_value: input}),
        });
    }

    useEffect(() => {
        getFetcher(`wordmix/get-option/${key}`);
    }, [key]);

    useEffect(() => {
        setValue(getData);
    }, [getData]);

    return [value, updateValue, saveLoading];
}