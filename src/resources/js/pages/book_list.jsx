import { React, useState, useEffect, useRef } from "react";
import axios from "axios";
import { BookTable } from '../components/book_table';
import { SidePanel } from "../components/side_panel";


const BookList = () => {
	const [bookListState, setBookListState] = useState({});
	const isFirstRender = useRef(true);
	useEffect(() => {
		isFirstRender.current = true;
	}, [])

	const getBookRequest = async () => {
		await axios.get('/sanctum/csrf-cookie').then(() => {
			axios.get("/api/v1/book?page=1&sort=1&freeword=")
			.then(data => {
				setBookListState(data.data.data);
			})
			.catch(data => {
			})
		})
		.catch((data) => {
		})
	}
	useEffect(() => {
		getBookRequest();
		// console.log(bookListState);
	}, [])

	if(isFirstRender.current === true){
		return(
			<>
			<div className="flex">
			<SidePanel />
			<BookTable lists={bookListState} />
			</div>
			</>
		);
	}
	else {
		return(
			<div>Now Loading</div>
		);
	}
}
export { BookList };