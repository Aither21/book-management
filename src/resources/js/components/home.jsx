import React from "react";

const Home = (props) => {
    const title = props.title;
    const explanation = props.explanation;
    const linkPreUserRegisterForm = props.linkPreUserRegisterForm;
    return (
        <>
        <h2>{title}</h2>
        <p className="text-red-500">{explanation}</p>
        <a href="/pre_user/register" className="border text-blue-500">{linkPreUserRegisterForm}</a>
        </>
    );
}

export default Home;