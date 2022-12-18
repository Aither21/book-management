import React from "react";

const Error = (props) => {
    const error = props.error;
    return (
        <>
        <p className="border p-5 text-center">{error}</p>
        </>
    );
}

export default Error;