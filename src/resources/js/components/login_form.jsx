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
		await axios.get('/sanctum/csrf-cookie').then(() => {
			axios.post("/api/login", {
				email: inputMail,
				password: inputPassword,
			})
			.then((response) => {
				console.log(response);
				const statusCode = response.status;
				console.log(statusCode);
				// if(statusCode === 200){
					axios.get('/api/user').then((data) => {
						const isAdmin = data.data.data.isAdmin;
						console.log(isAdmin);
						if(isAdmin === true){
							document.location = "/admin/book/list";
						}
						else {
							document.location = "/book/list";
						}
					})
					// }
				})
				.catch((error) => {
				// document.location = "/book/list";
				console.error(error);
				return;
			})
		})
	}

	return (
		<div>
			<section className="text-gray-600 body-font">
				<div className="container px-5 py-24 mx-auto flex flex-wrap items-center">
					<div className="bg-gray-100 rounded-lg p-8 flex flex-col w-full mt-10">
						<div className="relative mb-4">
							<label htmlFor="email" className="leading-7 text-sm text-gray-600">
								メールアドレス
							</label>
							<input type="email" name="email" className="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
								onChange={(event) => changeMail(event)}>
							</input>
						</div>
						<div className="relative mb-4">
							<label htmlFor="password" className="leading-7 text-sm text-gray-600">
								パスワード
							</label>
							<input type="text" name="password" className="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
								onChange={(event) => changePassword(event)}>
							</input>
						</div>
						<button className="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
							onClick={() => loginRequest(mailState, passwordState)}>
							ログイン
						</button>
						<p className="text-xs text-gray-500 mt-3">パスワードを忘れた方は<a href="" className="text-blue-500 underline decoration-blue-500">こちら</a></p>
					</div>
				</div>
			</section>
		</div>
	)
}


export default LoginForm;