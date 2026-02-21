package com.kevin.movies.repositories;

import org.springframework.data.jpa.repository.JpaRepository;

import com.kevin.movies.models.Movie;

public interface MovieRepository extends JpaRepository<Movie, Long> {

}
