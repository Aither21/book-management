import { useState } from "react";
import { useSearchParams } from 'react-router-dom';
import axios from "axios";


const MailForm = (props) => {
	const [SearchParams] = useSearchParams();
	const mail = SearchParams.get('mail');
	const [nameState, setNameState] = useState('');
	const [mailState, setMailState] = useState('');
	const [passwordState, setPasswordState] = useState('');
	const [passwordConfirmationState, setPasswordConfirmationState] = useState('');
	const [validateError, setValidateError] = useState('');
	const [SendState, setSendState] = useState(false);

	const changeName = (event) => {
		setNameState(event.target.value);
	}
	const changeMail = (event) => {
		setMailState(event.target.value);
	}
	const changePassword = (event) => {
		setPasswordState(event.target.value);
	}
	const changePasswordConfirmation = (event) => {
		setPasswordConfirmationState(event.target.value);
	}
	const changeSendState = (event) => {
		setSendState(event.target.value);
	}

	async function registerRequest(inputName, inputMail, inputPassword, inputPasswordConfirmation) {
		await axios.post("/api/register", {
			name: inputName,
			email: inputMail,
			password: inputPassword,
			password_confirmation: inputPasswordConfirmation,
		})
		.then((response) => {
			const statusCode = response.status;
			console.log(statusCode);
			if(statusCode === 201){
				setSendState(true);
				return;
			}
		})
		.catch((error) => {
			console.error(error);
			return;
		})
	}

	return (
		<>
		{
			SendState === false ?
			<>
			<p>仮登録情報を入力してください</p>
			<p className="text-red-500">{validateError}</p>
			<input type="text" name="name" className="border" onChange={(event) => changeName(event)}></input>
			<input type="text" name="mail" className="border" onChange={(event) => changeMail(event)}></input>
			<input type="text" name="password" className="border" onChange={(event) => changePassword(event)}></input>
			<input type="text" name="password_confirmation" className="border" onChange={(event) => changePasswordConfirmation(event)}></input>
			<button onClick={() => registerRequest(nameState, mailState, passwordState, passwordConfirmationState)}>仮登録する</button>
			</>
			:
			<>
			<p>仮登録できました</p>
			<p>受信したURLから本登録を完了してください！</p>
			</>
		}
		</>
	)
}

// const instance = axios.create({
// 	method: 'GET',
// 	baseURL: "/api/user",
// });

// async function fetchData() {
	// 	let response = await axios.post("/api/register", {
	// 		name: "しろたん",
	// 		email: "shirotan@gmail.com",
	// 		password: "password",
	// 		password_confirmation: "password"
	// 	});
	// 	return response;
	// }
// const validate = (mail) => {
// 	const mailInputElement = document.querySelector('.mail');
// 	setMailState(mailInputElement.value);
// 	if(mailState.length < 1){
// 		setValidateError('2文字以上で入力してください');
// 	}
// 	else {
// 		setValidateError('');
// 	}
// }



// const request = () => {
// 	const requestOptions = {
// 		method: 'GET',
// 		headers:{'Content-Type': 'application/json'},
// 		body: JSON.stringify('あ')
// 	}
// 	const url = '/api/user';//リクエスト先のURL
// 	const result = fetch(url,requestOptions);
// 	console.log(result);
// }

// const request = (mail) => {
// 	const requestOptions = {
// 		method: 'GET',
// 		headers:{'Content-Type': 'application/json'},
// 		body: JSON.stringify({mail: {mail}})//入力されたメールアドレス
// 	}
// 	const url = '/api/user';//リクエスト先のURL
// 	const result = fetch(url,requestOptions);
// 	console.log(result);
// }

export default MailForm;