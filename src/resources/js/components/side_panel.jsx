import { React } from "react";
import axios from "axios";

const SidePanel = () => {

	async function logoutRequest() {
		axios.post("/api/logout")
		.then((response) => {
			console.log(response);
			const statusCode = response.status;
			console.log(statusCode);
			document.location = "/login";
		})
		.catch((error) => {
			console.error(error);
			return;
		})
	}

	return (
		<div className="left-0 flex-col">
			<aside className="w-48" aria-label="Sidebar">
				<div className="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
						<ul className="space-y-2">
							<li>
									<a href="#" className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
										<svg aria-hidden="true" className="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
										<span className="ml-3">図書一覧</span>
									</a>
							</li>
							<li>
									<a href="#" className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
										<svg aria-hidden="true" className="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
										<span className="flex-1 ml-3 whitespace-nowrap">アカウント</span>
									</a>
							</li>
							<li onClick={logoutRequest}>
									<a href="#" className="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
										<svg aria-hidden="true" className="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"></path></svg>
										<span className="flex-1 ml-3 whitespace-nowrap">ログアウト</span>
									</a>
							</li>
						</ul>
				</div>
			</aside>
			{/* <div className="flex flex-col">
				<button className="p-2 border">貸出中リスト</button>
				<button className="p-2 border" onClick={props.returnButton}>返却申請リスト</button>
				<button className="p-2 border" onClick={props.allButton}>全書籍リスト</button>
			</div> */}
		</div>
	);

}

export { SidePanel };