import { React } from "react";

const AdminBookReturn = (props) => {
	const BookId = props.id;
	const BookPath = `/book?bookId=${BookId}`;

	const allowReturnRequest = async () => {
		await axios.get('/sanctum/csrf-cookie').then((data) => {
			const sanctumStatus = data.status;
			console.log(`sanctumStatus:${sanctumStatus}`)
			if(sanctumStatus !== 204){
				location.href='/login';
			}
			else {
				axios.get('/api/user').then((data) => {
					const userId = data.data.data.id;
					axios.patch(`/api/v1/book-management/${BookId}`,{
						status: 3,
						userId: userId,
					})
					.catch(data => {
					})
				})
			}
		})
		.catch((data) => {
		})
	}

	const disallowReturnRequest = async () => {
		await axios.get('/sanctum/csrf-cookie').then((data) => {
			const sanctumStatus = data.status;
			console.log(`sanctumStatus:${sanctumStatus}`)
			if(sanctumStatus !== 204){
				location.href='/login';
			}
			else {
				axios.get('/api/user').then((data) => {
					const userId = data.data.data.id;
					axios.patch(`/api/v1/book-management/${BookId}`,{
						status: 1,
						userId: userId,
					})
					.catch(data => {
					})
				})
			}
		})
		.catch((data) => {
		})
	}

	return(
		<div className="flex flex-wrap flex-nowrap py-2">
			<div className="w-20 md:w-21 h-20 md:h-21 md:mb-0 mr-5 mb-0 flex-shrink-0 flex flex-col border justify-center items-center pb-1">
				<span className="font-semibold title-font text-gray-700">画像</span>
				<span className="mt-1 text-gray-500 text-sm">100×100</span>
			</div>
			<div className="md:flex-grow">
				<a href={BookPath}>
					<h2 className="text-1xl font-medium text-gray-900 title-font">{props.id}　{props.name}</h2>
				</a>
				<a className="text-indigo-500 inline-flex items-center">{props.author}
					<svg className="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" >
						<path d="M5 12h14"></path>
						<path d="M12 5l7 7-7 7"></path>
					</svg>
				</a>
				<a className="text-indigo-500 inline-flex items-center">{props.company}
					<svg className="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" >
						<path d="M5 12h14"></path>
						<path d="M12 5l7 7-7 7"></path>
					</svg>
				</a>
				<div className="flex">
					<button className={`flex ml-1 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded`}
					onClick={allowReturnRequest}>
						返却完了
					</button>
					<button className={`flex ml-1 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded`}
					onClick={disallowReturnRequest}>
						返却却下
					</button>
				</div>
			</div>
		</div>
	);
}

export {AdminBookReturn} ;