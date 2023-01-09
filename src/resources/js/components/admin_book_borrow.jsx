import { React, useEffect } from "react";
import axios from "axios";

const AdminBookBorrow = (props) => {
	const BookId = props.id;
	const BookPath = `/book?bookId=${BookId}`;

	const allowBorrowRequest = async () => {
		await axios.get('/sanctum/csrf-cookie').then((data) => {
			const sanctumStatus = data.status;
			console.log(sanctumStatus)
			if(sanctumStatus !== 204){
				location.href='/login';
			}
			else {
				axios.get('/api/user').then((data) => {
					const userId = data.data.data.id;
					console.log(typeof(userId))
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
	
	const disallowBorrowRequest = async () => {
		await axios.get('/sanctum/csrf-cookie').then((data) => {
			const sanctumStatus = data.status;
			console.log(sanctumStatus)
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
						console.log(data)
					})
				})
			}
		})
		.catch((data) => {
			console.log(data)
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
					onClick={allowBorrowRequest}>
						貸出許可
					</button>
					<button className={`flex ml-1 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded`}
					onClick={disallowBorrowRequest}>
						貸出却下
					</button>
				</div>
			</div>
		</div>
	);
}

export {AdminBookBorrow};