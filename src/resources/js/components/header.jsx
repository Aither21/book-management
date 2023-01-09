import { React, useEffect, useState } from "react";

const Header = (props) => {
	const [screenNameState, setScreenNameState] = useState(': ');
	const decideHeader = () => {
		const correntPath = location.pathname;
		switch(correntPath){
			case '/':
				setScreenNameState("ホーム");
				break;
			case '/pre_user/register':
				setScreenNameState("仮会員登録");
				break;
			case '/login':
				setScreenNameState('ログイン');
				break;
			case '/book/list':
				setScreenNameState('図書一覧');
				break;
			case '/book':
				setScreenNameState('図書詳細');
				break;
			case '/admin/book/borrow/list':
				setScreenNameState('図書貸出申請一覧');
				break;
			case '/admin/book/return/list':
				setScreenNameState('図書返却申請一覧');
				break;
			case '/admin/book/lent/list':
				setScreenNameState('図書貸出中一覧');
				break;
			default:
				setScreenNameState('Not Found')
		}
	}
	useEffect(() => {
		decideHeader();
	}, [])

	return (
		<header className="text-gray-600 body-font">
			<div className="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
				<h1 className="flex order-first lg:order-none lg:w-2/5 title-font font-medium items-center text-gray-900 lg:items-center lg:justify-center mb-4 md:mb-0">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" className="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
						<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
					</svg>
					<span className="mx-3 text-xl">Book-Management</span>
				</h1>
				<div className="lg:w-2/5 inline-flex lg:justify-start ml-5 lg:ml-0">
					<p className="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none rounded text-base mt-0">
						{screenNameState}
					</p>
				</div>
			</div>
		</header>
	);
}

export default Header;