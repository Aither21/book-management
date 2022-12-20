import { useState } from "react";
import { useSearchParams } from 'react-router-dom';
import axios from "axios";


const MailForm = (props) => {
	const [SearchParams] = useSearchParams();
  const mail = SearchParams.get('mail');
	const [mailState, setMailState] = useState('');
	const [validateError, setValidateError] = useState('');
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
	async function fetchData2() {
		let response = await axios.post("/api/login", {
			email: "shirotan@gmail.com",
			password: "password",
		})
		.then((response) => {
			let responce2 = responce.json();
			return responce2;
		})
	}
	// const responce = fetchData();
	const result = fetchData2();
	// console.log(responce);
	console.log(result);

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
	return (
		<>
		{
			mail ?
			<p className="text-2xl">メールアドレスが送信されました！</p> :
			<>
			<p>メールアドレスを入力してください</p>
			<p className="text-red-500">{validateError}</p>
			<form action="">
			<input type="text" name="mail" className="mail border"></input>
			<input type="submit" value="仮登録する" className="border"/>
			</form>
			<button onClick={() => request(mail)}>リクエストする</button>
			</> 
		}
		</>
	);
}



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