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
		await axios.get('/sanctum/csrf-cookie').then(() => {
			axios.post("/api/register", {
				name: inputName,
				email: inputMail,
				password: inputPassword,
				password_confirmation: inputPasswordConfirmation,
			})
			.then((response) => {
				const statusCode = response.status;
				if(statusCode === 201||statusCode === 200){
					setSendState(true);
					return;
				}
			})
			.catch((error) => {
				console.error(error);
				return;
			})
		})
	}

	return (
		<>
		{
			SendState === false ?

			<div>
				<section className="text-gray-600 body-font">
					<div>仮登録情報を入力してください</div>
					<div className="text-red-500">{validateError}</div>
					<div className="container px-5 py-5 mx-auto flex flex-wrap items-center">
						<div className="bg-gray-100 rounded-lg p-8 flex flex-col w-full">
							<div className="relative mb-4">
								<label htmlFor="email" className="leading-7 text-sm text-gray-600">
									名前
								</label>
								<input type="name" name="name" className="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
									onChange={(event) => changeName(event)}>
								</input>
							</div>
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
							<div className="relative mb-4">
								<label htmlFor="password" className="leading-7 text-sm text-gray-600">
									パスワード（確認）
								</label>
								<input type="text" name="password" className="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
									onChange={(event) => changePasswordConfirmation(event)}>
								</input>
							</div>
							<button className="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
								onClick={() => registerRequest(nameState, mailState, passwordState, passwordConfirmationState)}>
								仮登録する
							</button>
						</div>
					</div>
				</section>
			</div>
			:
			<div>
			<p>仮登録が完了しました</p>
			<p>受信したURLから本登録を完了してください！</p>
			</div>
			}



			{/* <p className="w-44 mt-2">名前：</p>
			<input width={50}
			type="text" name="name" className="border" onChange={(event) => changeName(event)}></input>
			
			<p className="w-44 mt-2">メール：</p>
			<input type="text" name="mail" className="border" onChange={(event) => changeMail(event)}></input>
			
			<p className="w-44 mt-2">パスワード：</p>
			<input type="text" name="password" className="border" onChange={(event) => changePassword(event)}></input>
			
			<p className="w-44 mt-2">パスワード(確認)：</p>
			<input type="text" name="password_confirmation" className="border" onChange={(event) => changePasswordConfirmation(event)}></input>
			
			<button className="mt-7 border p-4 cursor-pointer"
			onClick={() => registerRequest(nameState, mailState, passwordState, passwordConfirmationState)}>仮登録する</button>
		</> */}
		</>
	)
}

export default MailForm;