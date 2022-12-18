import React from "react";
import { useSearchParams } from 'react-router-dom';

const MailForm = (props) => {
	const [SearchParams] = useSearchParams();
  const mail = SearchParams.get('mail');
	return (
		<>
		<p className="error-message"></p>
		{
			mail ?
			<p className="text-blue-300">メールアドレスは入力されています</p> :
			<p>メールアドレスを入力してください</p>
		}
		<form action="">
			<input type="text" name="mail" className="border" value={mail}></input>
			<input type="submit" value="仮登録する" className="border"/>
		</form>
		</>
	);
}

export default MailForm;