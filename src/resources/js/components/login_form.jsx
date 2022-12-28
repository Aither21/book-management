import { useState } from "react";
import { useSearchParams } from 'react-router-dom';
import axios from "axios";

const LoginForm = (props) => {
	const [SearchParams] = useSearchParams();
	const mail = SearchParams.get('mail');
	const [mailState, setMailState] = useState('');
	const [passwordState, setPasswordState] = useState('');
	// const [validateError, setValidateError] = useState('');

	const changeMail = (event) => {
		setMailState(event.target.value);
	}
	const changePassword = (event) => {
		setPasswordState(event.target.value);
	}

    async function loginRequest(inputMail, inputPassword) {
		await axios.post("/api/login", {
			email: inputMail,
			password: inputPassword,
		})
		.then((response) => {
			const statusCode = response.status;
			console.log(statusCode);
			// if(statusCode === 201){
			// 	document.location = "/login";
			// 	return;
			// }
            if(statusCode === 200){
                document.location = "/book/list";
            }
		})
		.catch((error) => {
			console.error(error);
			return;
		})
	}

	return (
		<>
			<p>ログイン情報を入力してください</p>
			{/* <p className="text-red-500">{validateError}</p> */}
			<input type="text" name="mail" className="mail border" onChange={(event) => changeMail(event)}></input>
			<input type="text" name="password" className="password border" onChange={(event) => changePassword(event)}></input>
			<button onClick={() => loginRequest(mailState, passwordState)}>ログインする</button>
		</>
	)
}


export default LoginForm;