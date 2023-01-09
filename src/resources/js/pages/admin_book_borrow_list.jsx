import { React, useState, useEffect, useRef } from "react";
import axios from "axios";
import { AdminBookTableBorrow } from '../components/admin_book_table_borrow';

const AdminBookBorrowList = () => {
	const [bookListState, setBookListState] = useState({});
	const isFirstRender = useRef(false);
	useEffect(() => {
		isFirstRender.current = true;
	})

	const getBookRequest = async () => {
		await axios.get('/sanctum/csrf-cookie').then((data) => {
			const sanctumStatus = data.status;
			console.log(`sanctumStatus:${sanctumStatus}`)
			if(sanctumStatus !== 204){
				location.href='/login';
			}
			else {
				axios.get("/api/v1/book-management?status=1")
				.then(data => {
					setBookListState(data.data.data);
				})
				.catch(data => {
				})
			}
		})
		.catch((data) => {
		})
	}
	useEffect(() => {
		getBookRequest();
	}, [])

	if(isFirstRender.current === true){
		return(
			<div className="flex">
				<AdminBookTableBorrow lists={bookListState}/>
			</div>
		);
	}
	else {
		return(
			<div>Now Loading</div>
		);
	}
}
export { AdminBookBorrowList };