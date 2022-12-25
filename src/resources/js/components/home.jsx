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
        <a href="/login" className="border text-blue-500">ログイン画面へ</a>
        <a href="/book/list" className="border text-blue-500">図書一覧画面へ</a>
        </>
    );
}

export default Home;