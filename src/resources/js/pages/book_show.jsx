import { React, useState, useEffect } from "react";
import { useSearchParams } from "react-router-dom";
import axios from "axios";
import { BookDetail } from '../components/book_detail';

const BookShow = () => {
	const [searchParams] = useSearchParams();
	const bookId = searchParams.get("bookId");
	console.log(bookId);
	const [bookDetailState, setBookDetailState] = useState({});
	const getBookDetailRequest = async () => {
		await axios.get('/sanctum/csrf-cookie').then(() => {
			axios.get(`/api/v1/book/${bookId}`)
			.then(data => {
				setBookDetailState(data.data.data);
			})
			.catch(data => {
			})
		})
	}
	useEffect(() => {
		getBookDetailRequest();
	}, [])

	return(
		<>
		<div>
		<BookDetail detail={bookDetailState} />
		</div>
		</>
	);
}
export { BookShow };