import { useState } from "react";
import { useSearchParams } from 'react-router-dom';
import axios from "axios";


const BookList = (props) => {
	const [SearchParams] = useSearchParams();
	const mail = SearchParams.get('mail');
	const [bookDataState, setBookDataState] = useState('');

	async function getBookRequest() {
		await axios.get("/api/v1/book?page=1")
		.then((response) => {
			console.log(response.data)
			// const statusCode = response.status;
			// console.log(statusCode);
			// if(statusCode === 200){
			// 	setSendState(true);
			// 	return ;
			// }
		})
		.catch((error) => {
			console.error(error);
			return "表示できません";
		})
	}
	getBookRequest();

	return (
		<>
		<p>図書一覧画面です</p>
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

export default BookList;