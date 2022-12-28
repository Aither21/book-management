import React from "react";

const Header = (props) => {
    const screenName = props.screenName;
    return (
        <>
        <h1 className="border p-10 text-center">{screenName}</h1>
        </>
    );
}

export default Header;