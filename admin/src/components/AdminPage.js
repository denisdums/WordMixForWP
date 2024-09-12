import React, {useState} from 'react';
import useOption from "../hooks/useOption";
import Spinner from "./Spinner";

export default function AdminPage() {
    const [url, setUrl] = useState('');
    const [remixUrl, setRemixUrl, remixUrlLoading] = useOption('wordmixRemixUrl');

    return (
        <div className="py-10">
            <div className="max-w-4xl mx-auto bg-white p-10">
                <h1>WordMix</h1>
                <form className="py-10 flex flex-col gap-6">
                    <div className="w-full">
                        <label className="input input-bordered flex items-center gap-2">
                            Remix URL
                            <input type="text"
                                   defaultValue={remixUrl}
                                   className="grow border-none focus:border-none focus:shadow-none"
                                   placeholder="ex: localhost:3000"
                                   onChange={(e) => setUrl(e.target.value)}
                            />
                        </label>
                    </div>
                    <div>
                        <button className="btn btn-primary"
                                onClick={(e) => {
                                    e.preventDefault();
                                    setRemixUrl(url);
                                }}>
                            Valider
                            {remixUrlLoading && <Spinner/>}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}