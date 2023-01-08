import { React, useEffect, useState } from "react";
import axios from "axios";

const SidePanel = () => {
	const correntPath= location.pathname;
	const [isAdminState, setIsAdminState] = useState(false);
	const notDisplayPathes = ['/', '/pre_user/register', '/login'];
	const notDisplaySidePanel = notDisplayPathes.some((notDisplayPath) => {
		return correntPath === notDisplayPath;
	});

	async function IsAdminRequest() {
		await axios.get('/sanctum/csrf-cookie').then(() => {
			axios.get('/api/user').then((data) => {
				const isAdmin = data.data.data.isAdmin;
				console.log(isAdmin);
				if(isAdmin === true){
					setIsAdminState(true);
				}
				else {
					setIsAdminState(false);
				}
			})
			.catch((error) => {
				console.error(error);
				return;
			})
		})
	}
	useEffect(() => {
		IsAdminRequest();
	},[])
	
	async function logoutRequest() {
		await axios.post("/api/logout")
		.then((response) => {
			const statusCode = response.status;
			console.log(statusCode);
			document.location = "/login";
		})
		.catch((error) => {
			console.error(error);
			return;
		})
	}
	const [toLentState, setToLentState] = useState('/admin/book/lent/list');
	const [toReturnState, setToReturnState] = useState('/admin/book/return/list');
	const [toListState, setToListState] = useState('/book/list');

	const enableSidePanel = () => {
		switch(correntPath){
			case '/admin/book/lent_list':
				setToLentState('');
				break;
	
			case '/admin/book/return_list':
				setToReturnState('');
				break;
	
			case '/book/list':
				setToListState('');
				break;
		}
	}
	useEffect(() => {
		enableSidePanel();
	},[])

	const [navState, setNavState] = useState("inline");
	const [navIConState, setNavIconState] = useState("w-44");

	const toggleNav = () => {
		if(navState === "hidden"){
			setNavState("inline");
			setNavIconState("w-40");
		}
		else {
			setNavState("hidden");
			setNavIconState("w-16");
		}
	}

	if(notDisplaySidePanel){
		return;
	}
	else {
		if(isAdminState){
			return (
				<div className="left-0 flex-col fixed md:top-16 top-8">
					<aside className={navIConState} aria-label="Sidebar">
						<div className="overflow-y-auto bg-gray-50 rounded dark:bg-gray-800 py-1">
							<ul className="space-y-2">
								<li onClick={toggleNav}>
										<a className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
										<img src="https://flowbite.com/docs/images/logo.svg" className="h-6 sm:h-7" alt="Flowbite Logo" />
											<span className="flex-1 ml-3 whitespace-nowrap"></span>
										</a>
								</li>
								<li className={navState}>
										<a href={toLentState} className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
											<svg aria-hidden="true" className="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path><path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
											<span className="flex-1 ml-3 whitespace-nowrap">貸出</span>
											<span className="inline-flex justify-center items-center p-3 ml-3 w-3 h-3 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">3</span>
										</a>
								</li>
								<li className={navState}>
										<a href={toReturnState} className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
											<svg aria-hidden="true" className="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"></path></svg>
											<span className="flex-1 ml-3 whitespace-nowrap">返却</span>
										</a>
								</li>
								<li className={navState}>
										<a href={toListState} className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
											<svg aria-hidden="true" className="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
											<span className="flex-1 ml-3 whitespace-nowrap">図書一覧</span>
										</a>
								</li>
								<li className={navState}>
										<a href="#" className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
											<svg aria-hidden="true" className="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
											<span className="ml-3">全データ</span>
										</a>
								</li>
								<li className={navState}>
										<a href="#" className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
											<svg aria-hidden="true" className="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
											<span className="flex-1 ml-3 whitespace-nowrap">アカウント</span>
										</a>
								</li>
								<li className={navState} onClick={logoutRequest}>
										<a href="#" className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
											<svg aria-hidden="true" className="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"></path></svg>
											<span className="flex-1 ml-3 whitespace-nowrap">ログアウト</span>
										</a>
								</li>
							</ul>
					</div>
				</aside>
			</div>
			)
		}
		else {
			return (
				<div className="left-0 flex-col fixed md:top-16 top-8">
					<aside className={navIConState} aria-label="Sidebar">
						<div className="overflow-y-auto bg-gray-50 rounded dark:bg-gray-800 py-1">
								<ul className="space-y-2">
								<li onClick={toggleNav}>
										<a className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
										<img src="https://flowbite.com/docs/images/logo.svg" className="h-6 sm:h-7" alt="Flowbite Logo" />
											<span className="flex-1 ml-3 whitespace-nowrap"></span>
										</a>
								</li>
									<li className={navState}>
										<a href="#" className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
											<svg aria-hidden="true" className="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
											<span className="ml-3">図書一覧</span>
										</a>
									</li>
									<li className={navState}>
										<a href="#" className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
											<svg aria-hidden="true" className="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
											<span className="flex-1 ml-3 whitespace-nowrap">アカウント</span>
										</a>
									</li>
									<li className={navState} onClick={logoutRequest}>
										<a href="#" className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
											<svg aria-hidden="true" className="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"></path></svg>
											<span className="flex-1 ml-3 whitespace-nowrap">ログアウト</span>
										</a>
									</li>
								</ul>
						</div>
					</aside>
				</div>
			);
		}
	}
}

export { SidePanel };